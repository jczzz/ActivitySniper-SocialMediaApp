# Make sure the Apt package lists are up to date, so we're downloading versions that exist.
cookbook_file "apt-sources.list" do
    path "/etc/apt/sources.list"
end
execute 'apt_update' do
    command 'apt-get update'
end

# Base configuration recipe in Chef.
package "wget"
package "ntp"
package "nginx"
package "mysql-server"
package "php7.0"

cookbook_file "nginx-default" do
    path "/etc/nginx/sites-available/default"
end

cookbook_file "ntp.conf" do
    path "/etc/ntp.conf"
end

cookbook_file "pg_hba.conf" do
    path "/etc/postgresql/9.5/main/pg_hba.conf"
end

execute 'ntp_restart' do
    command 'service ntp restart'
end

execute 'nginx_restart' do
    command 'service nginx restart'
end

execute 'psql_restart' do
    command 'service postgresql restart'
end

execute 'database setup' do
    command 'echo "CREATE DATABASE mydb; CREATE USER ubuntu; GRANT ALL PRIVILEGES ON DATABASE mydb TO ubuntu;" | sudo -u postgres psql'
end

execute 'create contacts table' do
    command 'psql -U ubuntu -d mydb -a -f /home/ubuntu/project/chef/cookbooks/baseconfig/files/default/createtable.sql'
end

execute 'insert initial data' do
    command 'psql -U ubuntu -d mydb -a -f /home/ubuntu/project/chef/cookbooks/baseconfig/files/default/initial.sql'
end