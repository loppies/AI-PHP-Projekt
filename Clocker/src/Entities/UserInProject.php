<?php

namespace Clocker\Entities;

use Clocker\Services\UserRepository;

class UserInProject {
    protected $userId;
    protected $projectId;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     * @return UserInProject
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param mixed $projectId
     * @return UserInProject
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
        return $this;
    }


}