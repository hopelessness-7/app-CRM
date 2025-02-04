<?php

namespace App\Action;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

class ImageHandler
{
    private static function hasImagesMethod(Model $model): bool
    {
        // проверка, что связь к модели картинок существует
        return method_exists($model, 'images');
    }
    public static function get(Model $model, string $type): string
    {
        // проверяем связь
        if (!self::hasImagesMethod($model)) {
            throw new \Exception("The model does not support this method", 421);
        }

        return optional($model->images()->where('type', $type)->first())->path ?? '';
    }

    /**
     * @throws \Exception
     */
    public static function create(Model $model, $fileOrUrl, $patch, $type): void
    {
        if (!self::hasImagesMethod($model)) {
            throw new \Exception("The model does not support this method", 421);
        }

        $patchNewImage = ImageDownload::handler($fileOrUrl, $patch);

        // Создаем запись с путем до картинки
        $model->images()->create([
            'patch' => $patchNewImage,
            'type' => $type,
        ]);
    }
}
