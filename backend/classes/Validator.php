<?php
class Validator {
    public static function login(string $v): ?string {
        if ($v === '') return 'Введите логин';
        if (!preg_match('/^[A-Za-z0-9]{6,}$/', $v)) return 'Логин: латиница и цифры, минимум 6 символов';
        return null;
    }
    public static function password(string $v): ?string {
        if ($v === '') return 'Введите пароль';
        if (mb_strlen($v) < 6) return 'Пароль минимум 6 символов';
        return null;
    }
    public static function fullName(string $v): ?string {
        if ($v === '') return 'Введите ФИО';
        if (!preg_match('/^[А-Яа-яЁё\s]+$/u', $v)) return 'ФИО: кириллица и пробелы';
        return null;
    }
    public static function phone(string $v): ?string {
        if ($v === '') return 'Введите телефон';
        if (!preg_match('/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/', $v)) return 'Телефон: +7(XXX)XXX-XX-XX';
        return null;
    }
    public static function email(string $v): ?string {
        if ($v === '') return 'Введите e-mail';
        if (!filter_var($v, FILTER_VALIDATE_EMAIL)) return 'Некорректный e-mail';
        return null;
    }
}