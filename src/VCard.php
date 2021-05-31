<?php

namespace MElaraby\VCard;

use MElaraby\VCard\Properties\{BirthDay, Email, Gender, Kind, Member, Org, Photo, Role, Tel, Title, Url};
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\{Contracts\Support\Responsable, Http\Request, Http\Response, Support\Str};
use Symfony\Component\HttpFoundation\HeaderUtils;

class VCard implements Responsable
{
    use Traits\HasConditionalCalls;

    protected $fullName = null,
            $namePrefix = null,
            $firstName = null,
            $middleName = null,
            $lastName = null,
            $nameSuffix = null,
            $properties = [];

    /**
     * @return static
     */
    public static function make(): self
    {
        return new static();
    }

    /**
     * @param string|null $fullName
     * @return $this
     */
    public function fullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @param string|null $lastName
     * @param string|null $firstName
     * @param string|null $middleName
     * @param string|null $prefix
     * @param string|null $suffix
     * @return $this
     */
    public function name(
        ?string $lastName = null,
        ?string $firstName = null,
        ?string $middleName = null,
        ?string $prefix = null,
        ?string $suffix = null
    ): self
    {
        $this->namePrefix = $prefix;
        $this->firstName = $firstName;
        $this->middleName = $middleName;
        $this->lastName = $lastName;
        $this->nameSuffix = $suffix;

        return $this;
    }

    /**
     * @param string $email
     * @param array $types
     * @return $this
     */
    public function email(string $email, array $types = [Email::INTERNET]): self
    {
        $this->properties[] = new Email($email, $types);

        return $this;
    }

    /**
     * @param string $number
     * @param array $types
     * @return $this
     */
    public function tel(string $number, array $types = [Tel::VOICE]): self
    {
        $this->properties[] = new Tel($number, $types);

        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function url(string $url): self
    {
        $this->properties[] = new Url($url);

        return $this;
    }

    /**
     * @param string $photo
     * @return $this
     */
    public function photo(string $photo): self
    {
        $this->properties[] = new Photo($photo);

        return $this;
    }

    /**
     * @param DateTimeInterface $birthDay
     * @return $this
     */
    public function birthDay(DateTimeInterface $birthDay): self
    {
        $this->properties[] = new BirthDay($birthDay);

        return $this;
    }

    /**
     * Kind of v-card
     *
     * @param string $kind
     * @return $this
     */
    public function kind(string $kind): self
    {
        $this->properties[] = new Kind($kind);

        return $this;
    }

    /**
     * @param string $gender
     * @return $this
     */
    public function gender(string $gender): self
    {
        $this->properties[] = new Gender($gender);

        return $this;
    }

    /**
     * @param string|null $company
     * @param string|null $unit
     * @param string|null $team
     * @return $this
     */
    public function org(?string $company = null, ?string $unit = null, ?string $team = null): self
    {
        $this->properties[] = new Org($company, $unit, $team);

        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function title(string $title): self
    {
        $this->properties[] = new Title($title);

        return $this;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function role(string $role): self
    {
        $this->properties[] = new Role($role);

        return $this;
    }

    /**
     * @param string|null $mail
     * @param string|null $uuid
     * @return $this
     */
    public function member(?string $mail = null, ?string $uuid = null): self
    {
        $this->properties[] = new Member($mail, $uuid);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return collect([
            'BEGIN:VCARD',
            'VERSION:4.0',
            "FN;CHARSET=UTF-8:{$this->getFullName()}",
            $this->hasNameParts() ? "N;CHARSET=UTF-8:$this->lastName;$this->firstName;$this->middleName;$this->namePrefix;$this->nameSuffix" : null,
            array_map('strval', $this->properties),
            sprintf('REV:%s', Carbon::now()->toISOString()),
            'PRODID:-//OZZ vCard',
            'END:VCARD',
        ])->flatten()->filter()->implode(PHP_EOL);
    }

    /**
     * @return string
     */
    protected function getFullName(): string
    {
        return $this->fullName ?? collect([
                $this->namePrefix,
                $this->firstName,
                $this->middleName,
                $this->lastName,
                $this->nameSuffix,
            ])->filter()->implode(' ');
    }

    /**
     * @return bool
     */
    protected function hasNameParts(): bool
    {
        return !empty(array_filter([
            $this->namePrefix,
            $this->firstName,
            $this->middleName,
            $this->lastName,
            $this->nameSuffix,
        ]));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function toResponse($request): Response
    {
        $content = strval($this);

        $filename = Str::of($this->getFullName())->slug('_')->append('.vcf');

        return new Response($content, 200, [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Type' => 'text/vcard',
            'Content-Length' => Str::length($content),
            'Content-Disposition' => HeaderUtils::makeDisposition(
                HeaderUtils::DISPOSITION_ATTACHMENT,
                $filename,
                $filename->ascii()->replace('%', '')
            ),
        ]);
    }
}
