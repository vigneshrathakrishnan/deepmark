#!/bin/bash

echo "🚀 Starting WordPress setup..."

# Check if .env exists
if [ ! -f .env ]; then
  echo "❌ Missing .env file. Setup cannot continue."
  exit 1
fi

echo "🔧 Building Docker containers..."
docker compose up -d --build

echo "⏳ Waiting for MySQL to be ready..."
sleep 15

echo "📦 Importing database..."
docker cp db-dump.sql wp-db:/db-dump.sql
docker exec wp-db bash -c "mysql -u root -p${MYSQL_ROOT_PASSWORD} ${MYSQL_DATABASE} < /db-dump.sql"

echo "✅ Site is up! Visit http://localhost:8180"