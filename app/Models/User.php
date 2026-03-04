<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'avatar_url',
        'whatsapp_verified',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'whatsapp_verified' => 'boolean',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relations
    public function lecturer()
    {
        return $this->hasOne(Lecturer::class, 'user_id'); // sesuaikan foreign key-nya
    }

    public function screeningResponses()
    {
        // Pastikan nama model ScreeningResponse sudah benar
        return $this->hasMany(ScreeningResponse::class, 'user_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    public function otpRequests()
    {
        return $this->hasMany(OtpRequest::class);
    }

    public function loginAttempts()
    {
        return $this->hasMany(LoginAttempt::class, 'destination', 'email');
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isLecturer(): bool
    {
        return $this->role === 'lecturer';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public static function updateLastLogin($userId): void
    {
        self::where('id', $userId)->update(['last_login_at' => now()]);
    }

    /**
     * Get the avatar URL attribute.
     */
    public function getAvatarUrlAttribute($value): ?string
    {
        if (!$value) {
            return asset('images/ava-default.png');
        }

        // Jika sudah full URL (http/https), return as is
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // Jika path sudah dimulai dengan storage/, gunakan asset
        if (str_starts_with($value, 'storage/')) {
            return asset($value);
        }

        // Jika path dimulai dengan /storage/, gunakan asset
        if (str_starts_with($value, '/storage/')) {
            return asset($value);
        }

        // Jika path tanpa prefix, tambahkan storage/
        return asset('storage/' . $value);
    }
}
