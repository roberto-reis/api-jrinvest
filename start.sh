#!/bin/bash

echo "########## COPIANDO ENV ##########"
cp .env.example .env

echo "########## INICIANDO PROJETO ##########"
docker-compose up -d
