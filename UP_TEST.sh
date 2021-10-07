#!/bin/bash

echo ""
echo ""
echo ""
echo ""
echo "Iniciando o processo de execução dos containers... "
echo ""
echo ""
echo ""
echo ""

echo ""
echo ""
echo "Criando a rede para os Containers Docker"
echo ""

docker network create --subnet '192.168.100.0/24' --gateway '192.168.100.1' --label 'com.docker.compose.network=default' --label 'com.docker.compose.project=allapps' allapps_default

echo ""
echo ""
echo "Creating image Liveecommerce Test"
docker build -t moizesdocker/php70apache:1.0   .
echo ""
echo ""
echo ""
echo "Image created."
echo ""
echo ""
echo ""
echo "Fazendo push para o DockerHub: moizesdocker/php70apache:1.0 "
docker push moizesdocker/php70apache:1.0

echo ""
echo ""
echo ""
rm  docker-compose.log
echo "Starting SISTEMA: 8061"
docker-compose up -d  >> docker-compose.log

echo ""
echo "Conectando containera rede principal... "
echo ""
echo ""
echo ""
docker network connect principal project_test_liveecommerce-app





