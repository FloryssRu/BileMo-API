<?php

namespace App\Services;

class HandlerAddLinks
{
    public function addLinksCollection($data): array
    {
        $response = [];

        foreach ($data as $item) {
            $class = strtolower(substr($item::class, 11)); //transforme "App\\Entity\\Product" en "product"

            //on ajoute quel que soit l'item le lien pour voir l'item
            //si l'item est de classe User alors on ajoute les liens de modif, suppression et création
            if ($class === "user") {
                $response[] = [
                    "item " . $item->getId() => $item,
                    "view" => "http://127.0.0.1:8000/api/" . $class . "s/" . $item->getId(),
                    "create" => "http://127.0.0.1:8000/api/users/create",
                    "edit" => "http://127.0.0.1:8000/api/" . $class . "s/edit/" . $item->getId(),
                    "delete" => "http://127.0.0.1:8000/api/" . $class . "s/delete/" . $item->getId()
                ];
            } else {
                $response[] = [
                    "item " . $item->getId() => $item,
                    "view" => "http://127.0.0.1:8000/api/" . $class . "s/" . $item->getId()
                ];
            }
        }

        return $response;
    }

    public function addLinksItem($item): array
    {
        $class = strtolower(substr($item::class, 11)); //transforme "App\\Entity\\Product" en "product"

        if ($class === "user") {
            $response = [
                "item" => $item,
                "collection" => "http://127.0.0.1:8000/api/" . $class . "s",
                "create" => "http://127.0.0.1:8000/api/users/create",
                "edit" => "http://127.0.0.1:8000/api/" . $class . "s/edit/" . $item->getId(),
                "delete" => "http://127.0.0.1:8000/api/" . $class . "s/delete/" . $item->getId()
            ];
        } else {
            $response = [
                "item" => $item,
                "collection" => "http://127.0.0.1:8000/api/" . $class . "s"
            ];
        }

        return $response;
    }
}