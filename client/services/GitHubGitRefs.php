<?php

require_once(__DIR__ . '/../GitHubClient.php');
require_once(__DIR__ . '/../GitHubService.php');
require_once(__DIR__ . '/../objects/GitHubRef.php');


class GitHubGitRefs extends GitHubService
{

    /**
     * Get a Reference
     *
     * @return GitHubRef
     */
    public function getReference($owner, $repo, $branch)
    {
        /**
         * The ref in the URL must be formatted as 'heads/branch', not just 'branch'
         */
        $ref = 'heads/'.$branch;
        $data = array();
        return $this->client->request("/repos/$owner/$repo/git/refs/$ref", 'GET', $data, 200, 'GitHubRef');
    }

    /**
     * Get all References
     *
     * @return GitHubRef
     */
    public function getAllReferences($owner, $repo)
    {
        $data = array();
        return $this->client->request("/repos/$owner/$repo/git/refs", 'GET', $data, 200, 'GitHubRef');
    }

    /**
     * Create a reference
     *
     * @param $branch string (Required) - The name of the branch
     * @param $sha string (Required) - The SHA1 value to set this reference to
     *
     * @return GitHubRef
     */
    public function createReference($owner, $repo, $branch, $sha)
    {
        /**
         * name > The name of the fully qualified reference (ie: refs/heads/master).
         * If it doesn't start with 'refs' and have at least two slashes, it will be rejected.
         */
        $name = 'refs/heads/'.$branch;
        $data = array(
            'name' => $name,
            'sha' => $sha
        );
        $data = json_encode($data);
        return $this->client->request("/repos/$owner/$repo/git/refs", 'POST', $data, 201, 'GitHubRef');
    }

    /**
     * Update a Reference
     *
     * @param $branch string (Required) - The branch to update its reference
     * @param $sha string (Required) - The SHA1 value to set this reference to
     * @param $force boolean (Optional) - Indicates whether to force the update or to make sure the update is a fast-forward update.
     *                                    Leaving this out or setting it to false will make sure you're not overwriting work.
     *                                    Default: false
     *
     * @return GitHubRef
     */
    public function updateReference($owner, $repo, $branch, $sha, $force=false)
    {
        /**
         * The ref in the URL must be formatted as 'heads/branch', not just 'branch'
         */
        $ref = 'heads/'.$branch;
        $data = array(
            'sha' => $sha,
            'force' => $force
        );
        $data = json_encode($data);
        return $this->client->request("/repos/$owner/$repo/git/refs/$ref", 'POST', $data, 200, 'GitHubRef');
    }

    /**
     * Delete a Reference
     *
     */
    public function deleteReference($owner, $repo, $name, $type='branch')
    {
        if ($type == 'tag') {
            $ref = 'tags/'.$name;
        } else {
            $ref = 'heads/'.$name;
        }
        $data = array();
        return $this->client->request("/repos/$owner/$repo/git/refs/$ref", 'DELETE', $data, 204, '');
    }
}
