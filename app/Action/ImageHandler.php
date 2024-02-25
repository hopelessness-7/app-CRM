<?php

namespace App\Action;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

class ImageHandler
{
    private static function hasImagesMethod(Model $model): bool
    {
        // проврека, что связь к модели картинок существет
        return method_exists($model, 'images');
    }
    public static function get(Model $model, $type): string
    {
        // проверяем связь
        if (!self::hasImagesMethod($model)) {
            throw new \Exception("The model does not support this method", 421);
        }

        foreach ($model->images as $image) {
           if ($image->type == $type) {
               return $image->patch;
           }
        }
    }

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

    public static function update(Model $model, $type, $patch): void
    {
        if (!self::hasImagesMethod($model)) {
            throw new \Exception("The model does not support this method", 421);
        }

        # найдите запись для обновления
        $image = $model->images()->where(['entity_type' => get_class($model), 'entity_id' => $model->id])->where('type', $type)->first();

        # Если не найдено, создайте новую
        if (!$image) {
            self::createAssets($model, $patch, $type);
            return;
        }

        # Если запись существует, обновите ее
        $image->$patch = $patch;
        $image->save();
    }
}
