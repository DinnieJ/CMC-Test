## PHP Test

@DinnieJ/php-test

### Requirements

- PHP >= 7.0
- Composer
- MySQL >= 5.7

### Dependencies

- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)

### Installation

```bash
#Clone this repository
git clone https://github.com/DinnieJ/CMC-Test

cd CMC-Test

# Copy the .env.example to .env (replace the values with your own)
cp .env.example .env

# Get the composer vendor and autoload file
composer i

# Run database seeder and migrate
php seed.php

# Serve the application
php -S 127.0.0.1:8081 -t /public
```

### Description

*Base URL: http://127.0.0.1:8081*

- [GET] /song - Get all songs with paging
    - Parameters:
      - page (optional) : Current page number (default 1)
      - limit (optional) : Number of items per page (default 5)
- [GET] /song/{id} - Get a song by id
    - Parameters:
      - id (required) : Specific song id
- [POST] /song - Create new song
  - Body
    - title (required) : Song title
    - artist_name (required) : Song artist name
    - album_name (required) : Song album
    - year (required) : Song year
    - release_date (required) : Song release_date
- [PUT] /song/{id} - Edit a specific song
    - Parameters
      - id (required) : Specific song id
    - Body
        - title (optional) : Song title
        - artist_name (optional) : Song artist name
        - album_name (optional) : Song album
        - year (optional) : Song year
        - release_date (optional) : Song release date
- [DELETE] /song/{id} - Delete a specific song
    - Parameters:
        - id (required) : Specific song id
- [GET] /movie - Get all movies with paging
    - Parameters:
      - page (optional) : Current page number (default 1)
      - limit (optional) : Number of items per page (default 5)
- [GET] /movie/{id} - Get a movie by id
    - Parameters:
      - id (required) : Specific movie id
- [POST] /movie - Create new movie
  - Body
    - title (required) : Movie title
    - description (required) : Movie description
    - director_name (required) : Movie director name
    - year (required) : Movie year
    - release_date (required) : Movie release_date
- [PUT] /movie/{id} - Edit a specific movie
    - Parameters
      - id (required) : Specific movie id
    - Body
      - title (optional) : Movie title
      - description (optional) : Movie description
      - director_name (optional) : Movie director name
      - year (optional) : Movie year
      - release_date (optional) : Movie release date
- [DELETE] /movie/{id} - Delete a specific movie
    - Body:
        - id (required) : Specific movie id