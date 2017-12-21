<?php

require_once(__DIR__ . '/../GitHubClient.php');
require_once(__DIR__ . '/../GitHubService.php');
require_once(__DIR__ . '/../objects/GitHubTree.php');
require_once(__DIR__ . '/../objects/GitHubTreeExtra.php');


class GitHubGitTrees extends GitHubService
{

    /**
     * Get a Tree
     *
     * @return GitHubTreeExtra
     */
    public function getTree($owner, $repo, $sha)
    {
        $data = array();
        return $this->client->request("/repos/$owner/$repo/git/trees/$sha", 'GET', $data, 200, 'GitHubTreeExtra');
    }

    /**
     * Get a Tree Recursively
     *
     * @return GitHubTreeExtra
     */
    public function getTreeRecursively($owner, $repo, $sha)
    {
        $data = array();
        return $this->client->request("/repos/$owner/$repo/git/trees/$sha?recursive=1", 'GET', $data, 200, 'GitHubTreeExtra');
    }

    /**
     * Post a Tree
     *
     * @param $tree array - The different objects to be in this tree
     * @param $base_tree string - the sha of the base tree
     *
     * @return GitHubBlob
     */
    public function createTree($owner, $repo, $tree, $base_tree)
    {
        $data = array(
            'tree' => $tree,
            'base_tree' => $base_tree
        );
        $data = json_encode($data);
        return $this->client->request("/repos/$owner/$repo/git/trees", 'POST', $data, 201, 'GitHubTreeExtra');
    }
}
