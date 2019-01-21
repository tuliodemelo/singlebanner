<?php

namespace Fulcrum\Banner\Api\Data;

/**
 * @api
 */
interface BannersInterface
{
    const ID = 'id';
    const TITLE = 'title';
    const HTML_CONTENT = 'html_content';
    const IS_ACTIVE = 'is_active';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get html content.
     *
     * @return string
     */
    public function getHtmlContent();

    /**
     * Get banner status.
     *
     * @return mixed
     */
    public function getIsActive();

    /**
     * Set banner id.
     *
     * @param $id
     * @return BannersInterface
     */
    public function setId($id);

    /**
     * Set banner title.
     *
     * @param $title
     * @return BannersInterface
     */
    public function setTitle($title);

    /**
     * Set banner html content.
     *
     * @param $htmlContent
     * @return BannersInterface
     */
    public function setHtmlContent($htmlContent);

    /**
     * Set banner status.
     *
     * @param $is_active
     * @return mixed
     */
    public function setIsActive($is_active);

}