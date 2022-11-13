<?php

namespace Moco\Service;

use Moco\Entity\MocoEntityInterface;
use Moco\Entity\Project;
use Moco\Service\Tarit\Create;
use Moco\Service\Tarit\Delete;
use Moco\Service\Tarit\Get;
use Moco\Service\Tarit\Update;

/**
 * @method Project create(array $params)
 * @method Project|array|null get(int|array|null $params = null)
 * @method Project update(int $id, array $params)
 * @method void delete(int $id)
 */
class ProjectsService extends AbstractService
{
    use Get;
    use Create;
    use Update;
    use Delete;

    protected function getEndpoint(): string
    {
        return $this->endpoint . 'projects';
    }

    protected function getEntity(): string
    {
        return Project::class;
    }

    protected function getMocoObject(): MocoEntityInterface
    {
        return new Project();
    }

    public function getAssignedProjects(array $params = []): array
    {
        $urlQuery = '';
        if (!empty($params)) {
            $params = $this->prepareParams($params);
            $urlQuery = '?' . http_build_query($params);
        }
        $result = $this->client->request("GET", $this->getEndPoint() . '/assigned' . $urlQuery);
        $result = json_decode($result);

        $entities = [];
        if (is_array($result)) {
            foreach ($result as $entity) {
                $entities[] = $this->createMocoEntity($entity, $this->getEntity());
            }
        }
        return $entities;
    }

    public function archive(int $projectId): Project
    {
        $result = $this->client->request("PUT", $this->getEndPoint() . '/' . $projectId . '/archive');
        $result = json_decode($result);
        return $this->createMocoEntity($result, $this->getEntity());
    }

    public function unarchive(int $projectId): Project
    {
        $result = $this->client->request("PUT", $this->getEndPoint() . '/' . $projectId . '/unarchive');
        $result = json_decode($result);
        return $this->createMocoEntity($result, $this->getEntity());
    }

    public function report(int $projectId): object
    {
        $result = $this->client->request("GET", $this->getEndPoint() . '/' . $projectId . '/report');
        return json_decode($result);
    }
}
