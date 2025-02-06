<?php

namespace App\Services\Client;

use App\Models\Deal;
use Illuminate\Database\Eloquent\Collection;

class FilterService
{
    public function filter(array $param): Collection|array
    {
        $dealQuery = Deal::query();

        if (!empty($param['status'])) {
            $dealQuery->where('status', $param['status']);
        }

        if (!empty($param['user_name'])) {
            $userNameParts = explode(' ', trim($param['user_name']));

            // Если в user_name несколько частей (например, фамилия, имя, отчество)
            if (count($userNameParts) > 1) {
                $dealQuery->whereHas('contact', function ($query) use ($userNameParts) {
                    $query->where(function($q) use ($userNameParts) {
                        $q->where('surname', 'like', '%' . $userNameParts[0] . '%'); // Фамилия
                        // Если есть вторая часть (например, имя)
                        if (isset($userNameParts[1])) {
                            $q->orWhere('first_name', 'like', '%' . $userNameParts[1] . '%'); // Имя
                        }
                        // Если есть третья часть (например, отчество)
                        if (isset($userNameParts[2])) {
                            $q->orWhere('patronymic', 'like', '%' . $userNameParts[2] . '%'); // Отчество
                        }
                    });
                });
            } else {
                // Если в user_name только одно слово (например, только фамилия)
                $dealQuery->whereHas('contact', function ($query) use ($param) {
                    $query->where('surname', 'like', '%' . $param['user_name'] . '%');
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
