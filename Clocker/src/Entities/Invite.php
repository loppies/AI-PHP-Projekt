<?php

namespace Clocker\Entities;

class Invite {
    protected $userId;
    protected $friendId;
    protected $projectId;
    protected $status;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     * @return Invite
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFriendId()
    {
        return $this->friendId;
    }

    /**
     * @param mixed $friendId
     * @return Invite
     */
    public function setFriendId($friendId)
    {
        $this->friendId = $friendId;
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
     * @return Invite
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Invite
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }


}