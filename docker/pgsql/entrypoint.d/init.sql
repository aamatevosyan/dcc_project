CREATE USER testing WITH PASSWORD 'secret';
ALTER USER testing CREATEDB;

create database dcc_project_testing;

GRANT ALL PRIVILEGES ON DATABASE dcc_project_testing TO testing;
