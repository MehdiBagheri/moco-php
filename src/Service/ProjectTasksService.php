<?php

namespace Moco\Service;

use Moco\Entity\AbstractMocoEntity;
use Moco\Entity\ProjectTask;
use Moco\Exception\InvalidRequestException;
use Moco\Service\Tarit\Create;
use Moco\Service\Tarit\Delete;
use Moco\Service\Tarit\Get;
use Moco\Service\Tarit\Update;

class ProjectTasksService extends AbstractService
{
    use Get {
        get as protected taritGet;
    }

    use Create {
        create as protected taritCreate;
    }

    use Update {
        update as protected taritUpdate;
    }

    use Delete {
        delete as protected taritDelete;
    }

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private int $projectId;

    protected function getEndpoint(): string
    {
        return $this->endpoint . 'projects/' . $this->projectId . '/tasks';
    }

    protected function getEntity(): string
    {
        return ProjectTask::class;
    }

    protected function getMocoObject(): AbstractMocoEntity
    {
        return new ProjectTask();
    }

    public function get(array $params): AbstractMocoEntity|array|null
    {
        $this->setProjectId($params);
        if (isset($params['id']) && is_int($params['id'])) {
            $params = $params['id'];
        }
        return $this->taritGet($params);
    }

    public function create(array $params): AbstractMocoEntity
    {
        $this->setProjectId($params);
        unset($params['project_id']);
        return $this->taritCreate($params);
    }

    public function update(array $params): AbstractMocoEntity
    {
        $this->setProjectId($params);
        if (isset($params['id']) && is_int($params['id'])) {
            $id = $params['id'];
            return $this->taritUpdate($id, $params);
        }
        throw new InvalidRequestException('Please provide the id!');
    }

    public function delete(array $params): void
    {
        $this->setProjectId($params);
        if (isset($params['id']) && is_int($params['id'])) {
            $id = $params['id'];
            $this->taritDelete($id);
        } else {
            throw new InvalidRequestException('Please provide the id!');
        }
    }

    public function destroyAll(int $id): void
    {
        $this->projectId = $id;
        $this->client->request("DELETE", $this->getEndPoint() . '/destroy_all');
    }

    private function setProjectId(array $params): void
    {
        if (empty($params['project_id'])) {
            throw new InvalidRequestException('please provide project_id!');
        }
        $this->projectId = $params['project_id'];
    }
}
