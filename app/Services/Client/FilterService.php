<?php

namespace App\Services\Client;

use App\Models\Deal;

class FilterService
{
    public function filter(array $param)
    {
        $dealQuery = Deal::query();

        if (!empty($param['status'])) {
            $dealQuery->where('status', $param['status']);
        }

        if (!empty($param['worker_id'])) {
            $dealQuery->where('worker_id', $param['worker_id']);
        }

        if (!empty($param['user_name'])) {
            $userNameParts = explode(' ', trim($param['user_name']));

            // Если в user_name несколько частей (например, фамилия, имя, отчество)
            if (count($userNameParts) > 1) {
                $dealQuery->whereHas('contact', function ($query) use ($userNameParts) {
                    $query->where(function($q) use ($userNameParts) {
                        $q->where('name', 'like', '%' . $userNameParts[0] . '%'); // Фамилия
                        // Если есть вторая часть (например, имя)
                        if (isset($userNameParts[1])) {
                            $q->orWhere('name', 'like', '%' . $userNameParts[1] . '%'); // Имя
                        }
                        // Если есть третья часть (например, отчество)
                        if (isset($userNameParts[2])) {
                            $q->orWhere('name', 'like', '%' . $userNameParts[2] . '%'); // Отчество
                        }
                    })
                        ->orWhere('email', 'like', '%' . implode(' ', $userNameParts) . '%') // Поиск по email
                        ->orWhere('phone', 'like', '%' . implode(' ', $userNameParts) . '%'); // Поиск по телефону
                });
            } else {
                // Если в user_name только одно слово (например, только фамилия)
                $dealQuery->whereHas('contact', function ($query) use ($param) {
                    $query->where('name', 'like', '%' . $param['user_name'] . '%')
                        ->orWhere('email', 'like', '%' . $param['user_name'] . '%')
                        ->orWhere('phone', 'like', '%' . $param['user_name'] . '%');
                });
            }
        }

        if (!empty($param['deal_id'])) {
            $dealQuery->whereHas('deal', function ($query) use ($param) {
                $query->where('id', $param['deal_id']);
            });
        }
        return $dealQuery->get();
    }
}
