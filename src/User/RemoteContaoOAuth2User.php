<?php
namespace Comolo\SuperLoginClient\ContaoEdition\User;


class RemoteContaoOAuth2User implements RemoteUserInterface
{
    protected $userData;
    protected $id;
    
    public function __construct()
    {
        $this->setDefaultUserData();
    }
    
    public function set($key, $value)
    {
        if ($field = $this->getFieldMap($key)) {
            $this->userData[$field] = $value;
        }
    }
    
    public function get($key)
    {
        return $this->has($key) ? $this->userData[$key] : null;
    }
    
    public function has($key)
    {
        return isset($this->userData[$key]);
    }
    
    protected function getFieldMap($field)
    {
        $mapping = [
            'full_name' => 'name',
            'username' => 'username',
            'email' => 'email',
            'language' => 'language',
        ];
        
        if (isset($mapping[$field])) {
            return $mapping[$field];
        }
        
        return null;
    }
    
    public function setDefaultUserData()
    {
        $this->userData = [
            'admin' => true,
            'language' => 'de', // Todo
        ];
    }
    
    public function validate()
    {
        $requiredFields = ['username', 'name', 'email'];
        
        foreach ($requiredFields as $field) {
            if (!$this->has($field)) {
                return false;
            }
        }
        
        return true;
    }
    
    public function toArray()
    {
        return $this->userData;
    }
    
    public function getUsername()
    {
        return $this->get('username');
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
}
