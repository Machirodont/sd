#82.146.60.209:44519
#/etc/ssh/sshd_config
#/etc/ssh/ssh_config
#Port 44519
service sshd restart
apt-get -y install sshguard
iptables -N sshguard
iptables -A INPUT -j sshguard
iptables -P INPUT ACCEPT
iptables -A INPUT -p tcp --dport 80 -j ACCEPT
iptables -A INPUT -p tcp --dport 443 -j ACCEPT
iptables -A INPUT -p tcp --dport 44519 -j ACCEPT
iptables-save

#/etc/network/if-up.d/iptables
#> #!/bin/sh
#> iptables-restore < /etc/firewall.conf
chmod +x /etc/network/if-up.d/iptables
iptables-save >/etc/firewall.conf

chmod +s /usr/sbin/sshguard
iptables-save > /etc/init.d/iptables
/usr/sbin/sshguard -l /var/log/messages

#Включаем mod_rewrite
a2enmod rewrite
# apache2.conf
#>AllowOverride All

#Убираем bind-address		= 127.0.0.1 в  /etc/mysql/my.cnf
#mysql >
CREATE USER 'sdmed'@'localhost' IDENTIFIED BY 'sdmeduserpass134';
CREATE USER 'adminuser'@'%' IDENTIFIED BY 'adminuserpass134';
GRANT ALL PRIVILEGES ON * . * TO 'sdmed'@'localhost';
GRANT ALL PRIVILEGES ON * . * TO 'adminuser'@'%';
FLUSH PRIVILEGES;
EXIT;

iptables -A INPUT -p tcp --dport 3306 -j ACCEPT

#Для включения ssl в apache
a2enmod ssl 