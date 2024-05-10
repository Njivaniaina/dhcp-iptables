#!/bin/bash

sudo iptables -F 

sudo iptables -A INPUT -m iprange --src-range 192.168.1.1-192.168.1.32 -j ACCEPT
sudo iptables -A INPUT -m iprange --src-range 192.168.1.34-192.168.1.62 -j ACCEPT
sudo iptables -A INPUT -m iprange --src-range 192.168.1.64-192.168.1.96 -j ACCEPT
sudo iptables -A INPUT -m iprange --src-range 192.168.1.98-192.168.1.130 -j ACCEPT
sudo iptables -A INPUT -m iprange --src-range 192.168.1.132-192.168.1.164 -j ACCEPT

sudo iptables -A FORWARD -m iprange --src-range 192.168.1.1-192.168.1.32 -j ACCEPT
sudo iptables -A FORWARD -m iprange --src-range 192.168.1.34-192.168.1.62 -j ACCEPT
sudo iptables -A FORWARD -m iprange --src-range 192.168.1.64-192.168.1.96 -j ACCEPT
sudo iptables -A FORWARD -m iprange --src-range 192.168.1.98-192.168.1.130 -j ACCEPT
sudo iptables -A FORWARD -m iprange --src-range 192.168.1.132-192.168.1.164 -j ACCEPT

sudo iptables -A OUTPUT -m iprange --src-range 192.168.1.1-192.168.1.32 -j ACCEPT
sudo iptables -A OUTPUT -m iprange --src-range 192.168.1.34-192.168.1.62 -j ACCEPT
sudo iptables -A OUTPUT -m iprange --src-range 192.168.1.64-192.168.1.96 -j ACCEPT
sudo iptables -A OUTPUT -m iprange --src-range 192.168.1.98-192.168.1.130 -j ACCEPT
sudo iptables -A OUTPUT -m iprange --src-range 192.168.1.132-192.168.1.164 -j ACCEPT