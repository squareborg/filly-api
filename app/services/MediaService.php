<?php
namespace App\Services;

use App\Models\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Merchant;

class MediaService
{
    const TYPE_AVATAR = 'image';
    const TYPE_LOGO = 'image';
    const TYPE_VIDEO = 'videos';

    protected $type;
    protected $user;
    protected $merchant;

    public function __construct()
    {
        $this->disk = config('filesystems.default');
    }

    public function storeImage(UploadedFile $file)
    {
        $this->type = self::TYPE_AVATAR;
        return $this->store($file);
    }

    public function storeLogo(UploadedFile $file)
    {
        $this->type = self::TYPE_LOGO;
        return $this->store($file);
    }

    public function storeProgramMedia($filename, UploadedFile $file)
    {
        if($file->storeAs('media', $filename, $this->disk)){
            return true;
        }
        return false;
    }

    public function storeVideo(UploadedFile $file)
    {
        $this->type = self::TYPE_VIDEO;
        return $this->store($file);
    }

    public function store(UploadedFile $file)
    {
        return $file->storeAs($this->path(), $this->filename($file), $this->disk);
    }

    public function delete($path)
    {
        return Storage::delete($path);
    }

    public function path()
    {
        if ($this->type === SELF::TYPE_LOGO) {
            return sprintf('%s/%s', $this->type, $this->merchant->id);
        }
        return sprintf('%s/%s', $this->type, $this->user->id);
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function setMerchant(Merchant $merchant)
    {
        $this->merchant = $merchant;
        return $this;
    }

    public function filename(UploadedFile $file)
    {
        return sprintf('%s.%s.%s', time(), rand(10, 1000), $file->getClientOriginalExtension());
    }
}
