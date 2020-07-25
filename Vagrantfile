# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.require_version ">= 1.8.7"

Vagrant.configure("2") do |config|
  config.vm.box = "bento/ubuntu-18.04"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  config.vm.define :joopdt do |joopdt|
    joopdt.vm.host_name = "legacy.eloo.test"
    joopdt.vm.network :private_network, ip: '33.33.33.16'
    joopdt.vm.synced_folder ".", "/vagrant", type: "nfs", nfs_udp: false

    joopdt.vm.provider "virtualbox" do |vb|
      vb.customize [ 'modifyvm', :id, '--chipset', 'ich9'] # solves kernel panic issue
      vb.customize [ 'modifyvm', :id, '--nic1', 'nat']
      vb.customize [ 'modifyvm', :id, '--nic2', 'hostonly']
    end

    joopdt.vm.provision "shell", inline: <<-SHELL
        wget https://apt.puppetlabs.com/puppet6-release-bionic.deb 2> /dev/null
        dpkg -i puppet6-release-bionic.deb
        apt-get update && apt-get install -y -q puppet-agent 2> /dev/null
    SHELL

    joopdt.vm.provision :puppet do |puppet|
        puppet.environment = 'development'
        puppet.environment_path = 'support/puppet/environments'
        puppet.module_path = 'support/puppet/modules'
        puppet.manifest_file = 'site.pp'
        puppet.manifests_path = 'support/puppet/manifests'
        puppet.hiera_config_path = 'support/puppet/hiera_vagrant.yaml'
        puppet.working_directory = '/vagrant'
        puppet.options = [
            '--verbose',
            #'--debug',
        ]
    end
  end
end
