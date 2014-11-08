# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  # Every Vagrant virtual environment requires a box to build off of.
  config.vm.box = "puphpet/debian75-x64"

  config.vm.provision :shell, path: "_development/vagrant/provision.sh"
  config.vm.provision :shell, path: "_development/vagrant/bootstrap.sh", run: "always"

  # Share project folder
  config.vm.synced_folder ".", "/vagrant", id: "vagrant-htdocs", :owner => "www-data", :group => "www-data"
  config.vm.synced_folder "/", "/vagrant/volume", id: "vagrant-volume", :owner => "www-data", :group => "www-data"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.80.200"

  config.vm.provider "virtualbox" do |v|
	v.name = "ImageDeletor"
  end


  config.vm.post_up_message = "Congrats! VM is up and running!"
end
