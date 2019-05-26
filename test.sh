#!/usr/bin/env bash

docker-compose -f docker-compose.yml exec auth-backend php vendor/codeception/base/codecept run
