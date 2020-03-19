cd client
npm run build

echo "Updating server-side files.."
cd ..
cp -R server app

echo "Deploying files to bitnami server.."