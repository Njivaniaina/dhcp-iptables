#sudo IPTABLES -F

sudo IPTABLES -A INPUT -m iprange --src-range 192.168.1.1-192.168.1.50
sudo IPTABLES -A INPUT -m iprange --src-range 192.168.1.51-192.168.1.100
sudo IPTABLES -A INPUT -m iprange --src-range 192.168.1.101-192.168.1.150
sudo IPTABLES -A INPUT -m iprange --src-range 192.168.1.151-192.168.1.200
sudo IPTABLES -A INPUT -m iprange --src-range 192.168.1.201-192.168.1.250


sudo IPTABLES -A OUTPUT -m iprange --src-range 192.168.1.1-192.168.1.50
sudo IPTABLES -A OUTPUT -m iprange --src-range 192.168.1.51-192.168.1.100
sudo IPTABLES -A OUTPUT -m iprange --src-range 192.168.1.101-192.168.1.150
sudo IPTABLES -A OUTPUT -m iprange --src-range 192.168.1.151-192.168.1.200
sudo IPTABLES -A OUTPUT -m iprange --src-range 192.168.1.201-192.168.1.250

sudo IPTABLES -A FORWARD -m iprange --src-range 192.168.1.1-192.168.1.50
sudo IPTABLES -A FORWARD -m iprange --src-range 192.168.1.51-192.168.1.100
sudo IPTABLES -A FORWARD -m iprange --src-range 192.168.1.101-192.168.1.150
sudo IPTABLES -A FORWARD -m iprange --src-range 192.168.1.151-192.168.1.200
sudo IPTABLES -A FORWARD -m iprange --src-range 192.168.1.201-192.168.1.250


