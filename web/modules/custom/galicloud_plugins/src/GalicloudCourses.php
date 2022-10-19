<?php

namespace Drupal\galicloud_plugins;

/**
 * Service description.
 */
class GalicloudCourses implements GalicloudCoursesInterface
{

  protected $courses;

  public function __construct($courses)
  {
    $this->courses = $courses;
  }

  public function getCourses()
  {
    return $this->courses;
  }

}
