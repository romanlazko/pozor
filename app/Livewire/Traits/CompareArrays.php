<?php

namespace App\Livewire\Traits;

trait CompareArrays
{
    public function compareArrays($params, $controllParams)
    {
        if (count($params) !== count($controllParams)) {
            return false;
        }
    
        // Итерируем по элементам массивов
        foreach ($params as $key => $value) {
            // Проверяем, есть ли ключ во втором массиве
            if (!array_key_exists($key, $controllParams)) {
                return false;
            }
    
            // Если значение - массив, вызываем функцию рекурсивно
            if (is_array($value)) {
                if (!$this->compareArrays($value, $controllParams[$key])) {
                    return false;
                }
            } else {
                // Сравниваем значения простых типов данных
                if ($value !== $controllParams[$key]) {
                    return false;
                }
            }
        }

        return true;
    }
}