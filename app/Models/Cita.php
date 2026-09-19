<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'paciente_id', 'doctor_id', 'inicio', 'fin', 'motivo', 'estado', 'cancelada_en',
    ];

    public const ESTADO_PENDIENTE = 'pendiente';
    public const ESTADO_CONFIRMADA = 'confirmada';
    public const ESTADO_CANCELADA = 'cancelada';
    public const ESTADO_ATENDIDA = 'atendida';

    public const COLORES = [
        self::ESTADO_PENDIENTE => '#f59e0b',
        self::ESTADO_CONFIRMADA => '#10b981',
        self::ESTADO_CANCELADA => '#ef4444',
        self::ESTADO_ATENDIDA => '#3b82f6',
    ];

    public const COLORES = [
        self::ESTADO_PENDIENTE => '#f59e0b',
        self::ESTADO_CONFIRMADA => '#10b981',
        self::ESTADO_CANCELADA => '#ef4444',
        self::ESTADO_ATENDIDA => '#3b82f6',
    ];


    public const ESTADOS = [
        self::ESTADO_PENDIENTE,
        self::ESTADO_CONFIRMADA,
        self::ESTADO_CANCELADA,
        self::ESTADO_ATENDIDA,
    ];

    public const COLORES = [
        self::ESTADO_PENDIENTE => '#f59e0b',
        self::ESTADO_CONFIRMADA => '#10b981',
        self::ESTADO_CANCELADA => '#ef4444',
        self::ESTADO_ATENDIDA => '#3b82f6',
    ];

    protected function casts(): array
    {
        return [
            'inicio' => 'datetime',
            'fin' => 'datetime',
            'cancelada_en' => 'datetime',
        ];
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function color(): string
    {
        return self::COLORES[$this->estado] ?? '#6b7280';
    }
}
