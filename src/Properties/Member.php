<?php

namespace MElaraby\VCard\Properties;

use Illuminate\Support\Str;
use InvalidArgumentException;

class Member extends Property
{
    protected $email;
    protected $uuid;

    /**
     * Member constructor.
     * @param string|null $email
     * @param string|null $uuid
     */
    public function __construct(?string $email, ?string $uuid)
    {
        $this->uuid = $uuid;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if($this->uuid) {
            $member = Str::start($this->uuid, 'urn:uuid:');
        } elseif($this->email) {
            $member = Str::start($this->email, 'mailto:');
        } else {
            throw new InvalidArgumentException('You have to pass at least one member identifier.');
        }

        return "MEMBER:{$member}";
    }
}
