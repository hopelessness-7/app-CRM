<?php

namespace App\Action;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageDownload
{
    public static function handler($fileOrUrl, $path): string
    {
        if (is_string($fileOrUrl)) {
            return self::downloadFile($fileOrUrl, $path);
        } elseif ($fileOrUrl instanceof \Illuminate\Http\UploadedFile) {
            return self::saveFile($fileOrUrl, $path);
        } else {
            throw new \Exception('Unknown data, you need to transfer a file or a link to a file', 400);
        }
    }

    protected static function downloadFile($url, $path): string
    {
        // Получаем содержимое файла по URL
        $contents = file_get_contents($url);
        if ($contents === false) {
            throw new \Exception('Failed to download file from URL', 500);
        }

        // Получаем расширение файла из URL
        $extension = pathinfo($url, PATHINFO_EXTENSION);
        self::validateExtension($extension);

        // Генерируем уникальное имя файла
        $fileName = Str::random(8) . '.' . $extension;

        // Путь к директории в хранилище
        $storagePath = 'public/' . $path;

        // Создаем директорию, если она не существует
        if (!Storage::exists($storagePath)) {
            Storage::makeDirectory($storagePath, 0755, true);
        }

        // Путь к файлу в хранилище
        $fullPath = $storagePath . '/' . $fileName;

        // Сохраняем файл в хранилище
        if (Storage::put($fullPath, $contents) === false) {
            throw new \Exception('Failed to save downloaded file', 500);
        }

        // Возвращаем путь к сохраненному файлу
        return $fullPath;
    }

    protected static function saveFile($file, $path): string
    {
        $extension = $file->getClientOriginalExtension();
        self::validateExtension($extension);

        $fileName = Str::random(8) . '.' . $extension;
        $filePath = $path . $fileName; // Формируем путь к файлу внутри public/$path

        // Сохраняем файл в хранилище
        if (Storage::putFileAs('public/' . $path, $file, $fileName)) {
            return $filePath; // Возвращаем путь к файлу
        } else {
            throw new \Exception('Failed to save uploaded file', 500);
        }
    }

    protected static function validateExtension($extension): void
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']; // Допустимые расширения файлов
        if (!in_array(strtolower($extension), $allowedExtensions)) {
            throw new \Exception('Invalid file type', 400);
        }
    }
}
