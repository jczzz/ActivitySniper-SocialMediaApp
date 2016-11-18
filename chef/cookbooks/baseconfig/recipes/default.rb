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
package "php7.0"
package "mysql-server"
package "php7.0-mysqlnd"
package "php7.0-xml"

cookbook_file "nginx-default" do
    path "/etc/nginx/sites-available/default"
end

cookbook_file "ntp.conf" do
    path "/etc/ntp.conf"
end

execute 'ntp_restart' do
    command 'service ntp restart'
end

execute 'nginx_restart' do
    command 'service nginx restart'
end

execute 'database setup' do
    command 'echo "CREATE DATABASE mydb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci; CREATE USER \'ubuntu\'@\'localhost\' IDENTIFIED BY \'ubuntu\'; GRANT ALL ON mydb.* TO \'ubuntu\'@\'localhost\';" | sudo -u root mysql'
end

execute 'create user table' do
    command 'mysql -u ubuntu -p"ubuntu" mydb < /home/ubuntu/project/mysql/user.sql'
end

execute 'create activity table' do
    command 'mysql -u ubuntu -p"ubuntu" mydb < /home/ubuntu/project/mysql/activity.sql'
end

execute 'create user_rel table' do
    command 'mysql -u ubuntu -p"ubuntu" mydb < /home/ubuntu/project/mysql/user_rel.sql'
end

execute 'create user_activity table' do
    command 'mysql -u ubuntu -p"ubuntu" mydb < /home/ubuntu/project/mysql/user_activity.sql'
end

execute 'create comment_board table' do
    command 'mysql -u ubuntu -p"ubuntu" mydb < /home/ubuntu/project/mysql/comment_board.sql'
end

execute 'create static folder' do
  command 'mkdir /home/ubuntu/static'
end

execute 'change folder permission' do
  command 'chmod 777 /home/ubuntu/static'
end

cookbook_file "default_act_pic.jpg" do
    path "/home/ubuntu/static/default_act_pic.jpg"
end

cookbook_file "default_user_pic.jpg" do
    path "/home/ubuntu/static/default_user_pic.jpg"
end


# insert initial activities to db
execute 'initial activities' do
    command 'mysql -u ubuntu -p"ubuntu" mydb < /home/ubuntu/project/mysql/initial_act.sql'
end
