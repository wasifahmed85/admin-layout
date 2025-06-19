<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AuthBaseModel extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    public function creater_admin()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->select(['name', 'id']);
    }

    public function updater_admin()
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'id')->select(['name', 'id']);
    }

    public function deleter_admin()
    {
        return $this->belongsTo(Admin::class, 'deleted_by', 'id')->select(['name', 'id']);
    }

    public function creater()
    {
        return $this->morphTo();
    }

    public function updater()
    {
        return $this->morphTo();
    }

    public function deleter()
    {
        return $this->morphTo();
    }

    protected $appends = [
       

        'status_label',
        'status_color',
        'status_btn_label',
        'status_btn_color',

        'created_at_human',
        'updated_at_human',
        'deleted_at_human',

        'created_at_formatted',
        'updated_at_formatted',
        'deleted_at_formatted',
    ];


    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public static function statusList(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }
    public function getStatusLabelAttribute()
    {
        return $this->status ? self::statusList()[$this->status] : 'Unknown';
    }

    public function getStatusColorAttribute()
    {
        return $this->status == self::STATUS_ACTIVE ? 'badge-success' : 'badge-error';
    }

    public function getStatusBtnLabelAttribute()
    {
        return $this->status == self::STATUS_ACTIVE ? self::statusList()[self::STATUS_INACTIVE] : self::statusList()[self::STATUS_ACTIVE];
    }

    public function getStatusBtnColorAttribute()
    {
        return $this->status == self::STATUS_ACTIVE ? 'btn-error' : 'btn-success';
    }


    


}
