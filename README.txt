C'est un projet en codeigniter qui peut gérer les services: 
  -> DHCP
  -> Netfilter

Les contributeurs
// Dans le fichier Participant.csv

INSTALL
  Pour faire usage de cette application web, on doit d'abord configurer certaines configurations dans le système.
  C'est-à-dire qu'on doit donner une permission à accéder à la configuration de Netfilter et du DHCP.
    - Ouvrir le fichier /etc/sudoers avec une permission root 
    - Écrire www-data "ALL=(ALL) NOPASSWD: ALL" : permettre de donner à l'utilisateur www-data d'exécuter n'importe quelle commande pour changer les configurations
    - Héberger le site sur un serveur (Apache, Xamp, .....)
    - Ouvrir votre navigateur et puis tester le site.
