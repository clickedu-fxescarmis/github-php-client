<?php

require_once(__DIR__ . '/../GitHubClient.php');
require_once(__DIR__ . '/../GitHubService.php');
require_once(__DIR__ . '/../objects/GitHubBlob.php');


class GitHubGitBlobs extends GitHubService
{

    /**
     * Get a Blob
     *
     * @return array<GitHubBlob>
     */
    public function getBlob($owner, $repo, $sha)
    {
        $data = array();
        return $this->client->request("/repos/$owner/$repo/git/blobs/$sha", 'GET', $data, 200, 'GitHubBlob', true);
    }

    /**
     * Post a Blob
     *
     * @param $content string (Required) - The new blob's content.
     * @param $encoding string (Optional) - The encoding used for content. Currently, "utf-8" and "base64" are supported. Default: "utf-8".
     *
     * @return GitHubBlob
     */
    public function createBlob($owner, $repo, $content, $encoding="utf-8")
    {
        $data = array(
            'content' => $content,
            'encoding' => $encoding
        );
        $data = json_encode($data);
        return $this->client->request("/repos/$owner/$repo/git/blobs", 'POST', $data, 201, 'GitHubBlob');
    }
}
