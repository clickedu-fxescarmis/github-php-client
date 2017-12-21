<?php

require_once(__DIR__ . '/../GitHubClient.php');
require_once(__DIR__ . '/../GitHubService.php');
require_once(__DIR__ . '/../objects/GitHubGitCommit.php');


class GitHubGitCommits extends GitHubService
{

    /**
     * Get a Commit
     *
     * @return GitHubGitCommit
     */
    public function getCommit($owner, $repo, $sha)
    {
        $data = array();
        return $this->client->request("/repos/$owner/$repo/git/commits/$sha", 'GET', $data, 200, 'GitHubGitCommit');
    }

    /**
     * Post a Commit
     *
     * @param $message string (Required) - The commit message
     * @param $tree string (Required) - The SHA of the tree object this commit points to
     * @param $parents array (Required) - The SHAs of the commits that were the parents of this commit.
     *                                    If omitted or empty, the commit will be written as a root commit.
     *                                    For a single parent, an array of one SHA should be provided;
     *                                    for a merge commit, an array of more than one should be provided.
     *
     * @return GitHubBlob
     */
    public function createCommit($owner, $repo, $message, $tree, $parents)
    {
        $data = array(
            'message' => $message,
            'tree' => $tree,
            'parents' => $parents
        );
        $data = json_encode($data);
        return $this->client->request("/repos/$owner/$repo/git/commits", 'POST', $data, 201, 'GitHubGitCommit');
    }

}
