<?php

namespace App\Providers;

class Validator
{
    private $errors = array();
    private $key;
    private $value;
    private $name;

    public function field($key, $value, $name = null)
    {
        $this->key = $key;
        $this->value = $value;
        if ($name == null) {
            $this->name = ucfirst($key);
        } else {
            $this->name = ucfirst($name);
        }
        return $this;
    }

    public function required()
    {
        if (empty($this->value)) {
            $this->errors[$this->key] = "$this->name est requis.";
        }
        return $this;
    }

    public function max($length)
    {
        if (strlen($this->value) > $length) {
            $this->errors[$this->key] = "$this->name doit contenir moins de $length caractères.";
        }
        return $this;
    }

    public function min($length)
    {
        if (strlen($this->value) < $length) {
            $this->errors[$this->key] = "$this->name doit contenir au moins $length caractères.";
        }
        return $this;
    }

    public function number()
    {
        if (!empty($this->value) && !is_numeric($this->value)) {
            $this->errors[$this->key] = "$this->name doit être un nombre.";
        }
        return $this;
    }

    public function int()
    {
        if (!filter_var($this->value, FILTER_VALIDATE_INT)) {
            $this->errors[$this->key] = "$this->name doit être un entier.";
        }
        return $this;
    }

    public function float()
    {
        if (!filter_var($this->value, FILTER_VALIDATE_FLOAT)) {
            $this->errors[$this->key] = "$this->name doit être un nombre décimal.";
        }
        return $this;
    }

    public function bigger($limit)
    {
        if ($this->value >= $limit) {
            $this->errors[$this->key] = "$this->name doit être supérieur ou égal à $limit.";
        }
        return $this;
    }

    public function lower($limit)
    {
        if ($this->value <= $limit) {
            $this->errors[$this->key] = "$this->name doit être inférieur ou égal à $limit.";
        }
        return $this;
    }

    public function email()
    {
        if (!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$this->key] = "Le format de $this->name est invalide.";
        }
        return $this;
    }

    public function validateDate($format = 'Y-m-d')
    {
        $date = \DateTime::createFromFormat($format, $this->value);
        if (!$date || $date->format($format) !== $this->value) {
            $this->errors[$this->key] = "Le format de $this->name est invalide. Veuillez utiliser le format $format.";
        }
        return $this;
    }


    public function isSuccess()
    {
        if (empty($this->errors)) return true;
    }

    public function getErrors()
    {
        if (!$this->isSuccess()) return $this->errors;
    }

    public function matches($comparisonValue, $comparisonName = null): self
    {
        $comparisonName = $comparisonName ?? 'value';
        if ($this->value !== $comparisonValue) {
            $this->errors[$this->key] = "$this->name doit correspondre à $comparisonName.";
        }
        return $this;
    }

    public function unique($model)
    {
        $model = 'App\\Models\\' . $model;
        $model = new $model;
        $unique = $model->unique($this->key, $this->value);
        if ($unique) {
            $this->errors[$this->key] = "$this->name doit être unique.";
        }
        return $this;
    }

    public function exists($model, $id)
    {
        $modelClass = 'App\\Models\\' . $model;
        $modelInstance = new $modelClass;
        $record = $modelInstance->selectAllFromTableById($model, $id);

        if (!$record) {
            $this->errors[$this->key] = "$this->name est introuvable.";
        }
        return $this;
    }

    public function notSameUserAsLastBid($auction_id)
    {
        $bidModel = new \App\Models\Bid();
        $lastBid = $bidModel->findBiggestValue($auction_id);

        if ($lastBid && $lastBid['user_id'] == $_SESSION['user_id']) {
            $this->errors[$this->key] = "Vous ne pouvez pas enchérir deux fois de suite.";
        }
        return $this;
    }

    public function minBid($auction)
    {
        if ($this->value <= $auction['floor_price']) {
            $this->errors[$this->key] = "Votre enchère doit être supérieure au prix de départ.";
        }
        return $this;
    }

    public function higherBid($auction_id)
    {
        $bidModel = new \App\Models\Bid();
        $biggestBid = $bidModel->findBiggestValue($auction_id);

        $minimumBid = $biggestBid ? $biggestBid['value'] + 1 : $auction_id['floor_price'];

        if ($this->value < $minimumBid) {
            $this->errors[$this->key] = "Votre enchère doit être supérieure à la mise actuelle ({$minimumBid}€).";
        }

        return $this;
    }

    public function connected()
    {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            $this->errors['user_id'] = "Vous devez être connecté pour enchérir.";
        }
        return $this;
    }
}
