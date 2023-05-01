CREATE TABLE `users` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(255) UNIQUE,
  `email` varchar(255) UNIQUE,
  `password` varchar(255) UNIQUE,
  `first_name` varchar(80),
  `last_name` varchar(80),
  `created_at` timestamp DEFAULT (now())
);

CREATE TABLE `posts` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255),
  `body` text COMMENT 'Content of the post',
  `user_id` integer,
  `created_at` timestamp DEFAULT (now()),
  `updated_times` integer,
  `updated_at` timestamp DEFAULT (now()),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `comments` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `user_id` integer,
  `post_id` integer,
  `reply_to` integer,
  `body` text COMMENT 'Content of the comment',
  `created_at` timestamp DEFAULT (now()),
  `updated_times` integer,
  `updated_at` timestamp DEFAULT (now()),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  FOREIGN KEY (`reply_to`) REFERENCES `comments` (`id`)
);

CREATE TABLE `likes` (
  `post_id` integer,
  `user_id` integer,
  `liked_at` timestamp DEFAULT (now()),
  PRIMARY KEY (`post_id`, `user_id`),
  FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `follows` (
  `following_user_id` integer,
  `followed_user_id` integer,
  `created_at` timestamp DEFAULT (now()),
  PRIMARY KEY (`following_user_id`, `followed_user_id`),
  FOREIGN KEY (`following_user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`followed_user_id`) REFERENCES `users` (`id`)
);