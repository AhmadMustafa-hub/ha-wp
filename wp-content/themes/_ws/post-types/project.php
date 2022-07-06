<?php
class ProjectMeta extends PostMeta {

}

new ProjectMeta('Project', [
  'template' => [
    ['ws/meta-project'],
    ['core/paragraph', ['placeholder' => 'Projects have their own template, so you only need to type the content of the post. Don\'t forget meta and featured image.']]
  ],
  'dashicon' => 'dashicons-portfolio',
  'url' => 'projects'
]);

new Taxonomy('Region', [
  'post_types' => ['project'],
  'description' => 'Taxonomy for projects.'
]);
new Taxonomy('Client', [
  'post_types' => ['project'],
  'description' => 'Taxonomy for projects.'
]);
new Taxonomy('Location', [
  'post_types' => ['project'],
  'description' => 'Taxonomy for projects.'
]);
new Taxonomy('Recognition', [
  'post_types' => ['project'],
  'description' => 'Taxonomy for projects.'
]);