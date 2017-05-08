<?php
// brad@chimera:~/git/cabrew/tools$ sudo apt-get install sendmail
// [sudo] password for brad:
// Reading package lists... Done
// Building dependency tree
// Reading state information... Done
// The following packages were automatically installed and are no longer required:
//   linux-headers-4.4.0-71 linux-headers-4.4.0-71-generic linux-headers-4.4.0-72
//   linux-headers-4.4.0-72-generic linux-hwe-edge-tools-4.10.0-14
//   linux-hwe-edge-tools-4.10.0-19 linux-image-4.4.0-71-generic
//   linux-image-4.4.0-72-generic linux-image-extra-4.4.0-71-generic
//   linux-image-extra-4.4.0-72-generic linux-signed-image-4.4.0-71-generic
//   linux-signed-image-4.4.0-72-generic linux-tools-4.10.0-14-generic
//   linux-tools-4.10.0-19-generic python3-systemd snap-confine
// Use 'sudo apt autoremove' to remove them.
// The following additional packages will be installed:
//   liblockfile-bin liblockfile1 m4 procmail sendmail-base sendmail-bin
//   sendmail-cf sensible-mda
// Suggested packages:
//   sendmail-doc rmail logcheck sasl2-bin
// The following NEW packages will be installed:
//   liblockfile-bin liblockfile1 m4 procmail sendmail sendmail-base sendmail-bin
//   sendmail-cf sensible-mda
// 0 upgraded, 9 newly installed, 0 to remove and 0 not upgraded.
// Need to get 1,067 kB of archives.
// After this operation, 4,673 kB of additional disk space will be used.
// Do you want to continue? [Y/n] y
// Get:1 http://us.archive.ubuntu.com/ubuntu xenial/main amd64 liblockfile-bin amd64 1.09-6ubuntu1 [10.8 kB]
// Get:2 http://us.archive.ubuntu.com/ubuntu xenial/main amd64 liblockfile1 amd64 1.09-6ubuntu1 [8,056 B]
// Get:3 http://us.archive.ubuntu.com/ubuntu xenial/main amd64 m4 amd64 1.4.17-5 [195 kB]
// Get:4 http://us.archive.ubuntu.com/ubuntu xenial/universe amd64 sendmail-base all 8.15.2-3 [138 kB]
// Get:5 http://us.archive.ubuntu.com/ubuntu xenial/universe amd64 sendmail-cf all 8.15.2-3 [85.8 kB]
// Get:6 http://us.archive.ubuntu.com/ubuntu xenial/universe amd64 sendmail-bin amd64 8.15.2-3 [479 kB]
// Get:7 http://us.archive.ubuntu.com/ubuntu xenial/main amd64 procmail amd64 3.22-25 [136 kB]
// Get:8 http://us.archive.ubuntu.com/ubuntu xenial/universe amd64 sensible-mda amd64 8.15.2-3 [8,362 B]
// Get:9 http://us.archive.ubuntu.com/ubuntu xenial/universe amd64 sendmail all 8.15.2-3 [6,316 B]
// Fetched 1,067 kB in 0s (2,437 kB/s)
// Selecting previously unselected package liblockfile-bin.
// (Reading database ... 333058 files and directories currently installed.)
// Preparing to unpack .../liblockfile-bin_1.09-6ubuntu1_amd64.deb ...
// Unpacking liblockfile-bin (1.09-6ubuntu1) ...
// Selecting previously unselected package liblockfile1:amd64.
// Preparing to unpack .../liblockfile1_1.09-6ubuntu1_amd64.deb ...
// Unpacking liblockfile1:amd64 (1.09-6ubuntu1) ...
// Selecting previously unselected package m4.
// Preparing to unpack .../archives/m4_1.4.17-5_amd64.deb ...
// Unpacking m4 (1.4.17-5) ...
// Selecting previously unselected package sendmail-base.
// Preparing to unpack .../sendmail-base_8.15.2-3_all.deb ...
// Unpacking sendmail-base (8.15.2-3) ...
// Selecting previously unselected package sendmail-cf.
// Preparing to unpack .../sendmail-cf_8.15.2-3_all.deb ...
// Unpacking sendmail-cf (8.15.2-3) ...
// Selecting previously unselected package sendmail-bin.
// Preparing to unpack .../sendmail-bin_8.15.2-3_amd64.deb ...
// Unpacking sendmail-bin (8.15.2-3) ...
// Selecting previously unselected package procmail.
// Preparing to unpack .../procmail_3.22-25_amd64.deb ...
// Unpacking procmail (3.22-25) ...
// Selecting previously unselected package sensible-mda.
// Preparing to unpack .../sensible-mda_8.15.2-3_amd64.deb ...
// Unpacking sensible-mda (8.15.2-3) ...
// Selecting previously unselected package sendmail.
// Preparing to unpack .../sendmail_8.15.2-3_all.deb ...
// Unpacking sendmail (8.15.2-3) ...
// Processing triggers for man-db (2.7.5-1) ...
// Processing triggers for install-info (6.1.0.dfsg.1-5) ...
// Processing triggers for systemd (229-4ubuntu17) ...
// Processing triggers for ureadahead (0.100.0-19) ...
// ureadahead will be reprofiled on next reboot
// Setting up liblockfile-bin (1.09-6ubuntu1) ...
// Setting up liblockfile1:amd64 (1.09-6ubuntu1) ...
// Setting up m4 (1.4.17-5) ...
// Setting up sendmail-base (8.15.2-3) ...
// adduser: Warning: The home directory `/var/lib/sendmail' does not belong to the user you are currently creating.
// Setting up sendmail-cf (8.15.2-3) ...
// Setting up sendmail-bin (8.15.2-3) ...
// update-alternatives: using /usr/lib/sm.bin/sendmail to provide /usr/sbin/sendmail-mta (sendmail-mta) in auto mode
// update-alternatives: using /usr/lib/sm.bin/sendmail to provide /usr/sbin/sendmail-msp (sendmail-msp) in auto mode

// You are doing a new install, or have erased /etc/mail/sendmail.mc.
// If you've accidentaly erased /etc/mail/sendmail.mc, check /var/backups.

// I am creating a safe, default sendmail.mc for you and you can
// run sendmailconfig later if you need to change the defaults.

// Updating sendmail environment ...
// Validating configuration.
// Writing configuration to /etc/mail/sendmail.conf.
// Writing /etc/cron.d/sendmail.
// Could not open /etc/mail/databases(No such file or directory), creating it.
// Could not open /etc/mail/sendmail.mc(No such file or directory)
// Reading configuration from /etc/mail/sendmail.conf.
// Validating configuration.
// Writing configuration to /etc/mail/sendmail.conf.
// Writing /etc/cron.d/sendmail.
// Turning off Host Status collection
// Could not open /etc/mail/databases(No such file or directory), creating it.
// Reading configuration from /etc/mail/sendmail.conf.
// Validating configuration.
// Creating /etc/mail/databases...

// Checking filesystem, this may take some time - it will not hang!
//   ...   Done.

// Checking for installed MDAs...
// Adding link for newly extant program (mail.local)
// Adding link for newly extant program (procmail)
// sasl2-bin not installed, not configuring sendmail support.

// To enable sendmail SASL2 support at a later date, invoke "/usr/share/sendmail/update_auth"


// Creating/Updating SSL(for TLS) information
// Creating /etc/mail/tls/starttls.m4...
// Creating SSL certificates for sendmail.
// Generating DSA parameters, 2048 bit long prime
// This could take some time
// .........+++++++++++++++++++++++++++++++++++++++++++++++++++*
// ..............+...................................+...........+......+.....+......................+............+..........+.........+...+........................................+................+..............+.............+.............+.........................+..+.+...........................+.....+..+......+.........+++++++++++++++++++++++++++++++++++++++++++++++++++*
// Generating RSA private key, 2048 bit long modulus
// .....................................................................................................................+++
// .....................................................+++
// e is 65537 (0x10001)

// *** *** *** WARNING *** WARNING *** WARNING *** WARNING *** *** ***

// Everything you need to support STARTTLS (encrypted mail transmission
// and user authentication via certificates) is installed and configured
// but is *NOT* being used.

// To enable sendmail to use STARTTLS, you need to:
// 1) Add this line to /etc/mail/sendmail.mc and optionally
//    to /etc/mail/submit.mc:
//   include(`/etc/mail/tls/starttls.m4')dnl
// 2) Run sendmailconfig
// 3) Restart sendmail


// Updating /etc/hosts.allow, adding "sendmail: all".

// Please edit /etc/hosts.allow and check the rules location to
// make sure your security measures have not been overridden -
// it is common to move the sendmail:all line to the *end* of
// the file, so your more selective rules take precedence.
// Checking {sendmail,submit}.mc and related databases...
// Reading configuration from /etc/mail/sendmail.conf.
// Validating configuration.
// Creating /etc/mail/databases...
// Reading configuration from /etc/mail/sendmail.conf.
// Validating configuration.
// Creating /etc/mail/databases...
// Reading configuration from /etc/mail/sendmail.conf.
// Validating configuration.
// Creating /etc/mail/Makefile...
// Reading configuration from /etc/mail/sendmail.conf.
// Validating configuration.
// Writing configuration to /etc/mail/sendmail.conf.
// Writing /etc/cron.d/sendmail.
// Disabling HOST statistics file(/var/lib/sendmail/host_status).
// Creating /etc/mail/sendmail.cf...
// Creating /etc/mail/submit.cf...
// Informational: confCR_FILE file empty: /etc/mail/relay-domains
// Warning: confCT_FILE source file not found: /etc/mail/trusted-users
//  it was created
// Informational: confCT_FILE file empty: /etc/mail/trusted-users
// Warning: confCW_FILE source file not found: /etc/mail/local-host-names
//  it was created
// Warning: access_db source file not found: /etc/mail/access
//  it was created
// Updating /etc/mail/access...
// Linking /etc/aliases to /etc/mail/aliases
// Informational: ALIAS_FILE file empty: /etc/mail/aliases
// Updating /etc/mail/aliases...
// WARNING: local host name (chimera) is not qualified; see cf/README: WHO AM I?
// /etc/mail/aliases: 0 aliases, longest 0 bytes, 0 bytes total

// Warning: 3 database(s) sources
// 	were not found, (but were created)
// 	please investigate.
// Setting up procmail (3.22-25) ...
// Setting up sensible-mda (8.15.2-3) ...
// Setting up sendmail (8.15.2-3) ...
// Processing triggers for libc-bin (2.23-0ubuntu7) ...
// /sbin/ldconfig.real: /usr/lib/nvidia-375/libEGL.so.1 is not a symbolic link

// /sbin/ldconfig.real: /usr/lib32/nvidia-375/libEGL.so.1 is not a symbolic link

// Processing triggers for systemd (229-4ubuntu17) ...
// Processing triggers for ureadahead (0.100.0-19) ...

// Delivered-To: braddoro@gmail.com
// Received: by 10.100.189.75 with SMTP id o11csp1168457pjf;
//         Sun, 7 May 2017 15:19:31 -0700 (PDT)
// X-Received: by 10.37.24.213 with SMTP id 204mr7689994yby.4.1494195570621;
//         Sun, 07 May 2017 15:19:30 -0700 (PDT)
// ARC-Seal: i=1; a=rsa-sha256; t=1494195570; cv=none;
//         d=google.com; s=arc-20160816;
//         b=po6+hIKERP7LH1G+RO3IyztXvidGUa9tZqo70EAg8+kvhvrTN8ckHgn3ojkHyAHwga
//          PC83Qg83OBEs3CnAeWUFhKZEUX4wXOSMNZz7SEQ8t/ZR4vr3/2/Fs+w96H+IjmBmBIMe
//          jAUMj03tUYmZRAh2WvtoZSQn11mmiy29lTCY32gykscNrSxjVKNrHVf54aOsGf1f3DkE
//          W72y8ylYBZjFkEp5+wl0YiZ6E15Km3agoo5zjGMobJ9d4XmQKpL8FCbBlfqpIS/SIH4p
//          FarzdWrgDJeKD82mAV2NccDSprGxtWawmUd7JoARhhNHtDaC/V3onmrXb0ahgyBvhDta
//          JzOg==
// ARC-Message-Signature: i=1; a=rsa-sha256; c=relaxed/relaxed; d=google.com; s=arc-20160816;
//         h=reply-to:from:subject:to:message-id:date:arc-authentication-results;
//         bh=36/AenyKaVojoYw9xeMCIBtNwOJa/gr6ETgpwDKHCtE=;
//         b=hHG3Qwq+KNw/z+jQkWYfprcFxKcoHFroZC2OsfyKaV8QESdsZQipyDG5xcx0zktN36
//          AQHN32iYEC+toCh3rSF19vVIRdPrw70ZpWXZWIObSi6P/f4FeV8VZQjsOadvKN6CBJTV
//          AltCM5apTds0wrRp9+YZM3jHF+IeBLFuJ+OIbBW7P5fEkWZSlDabcanX66D9jSyJRlbI
//          6/qTNGk+loMJ1+1a7YaghvRmief8FNRYiV43C/byucLS+49/x3wuDaLns+xmre8QiA1A
//          K3zvx3U2jktrLjLM52GygDIZ1nK9/zUR7gGrqSiUVGEtekztx0rfME1BkIoum0r+y4qu
//          toUg==
// ARC-Authentication-Results: i=1; mx.google.com;
//        spf=neutral (google.com: 173.92.47.29 is neither permitted nor denied by best guess record for domain of brad@chimera) smtp.mailfrom=brad@chimera;
//        dmarc=fail (p=NONE sp=NONE dis=NONE) header.from=gmail.com
// Return-Path: <brad@chimera>
// Received: from chimera (cpe-173-92-47-29.carolina.res.rr.com. [173.92.47.29])
//         by mx.google.com with ESMTPS id a11si4139082ywa.332.2017.05.07.15.19.30
//         for <braddoro@gmail.com>
//         (version=TLS1_2 cipher=ECDHE-RSA-AES128-GCM-SHA256 bits=128/128);
//         Sun, 07 May 2017 15:19:30 -0700 (PDT)
// Received-SPF: neutral (google.com: 173.92.47.29 is neither permitted nor denied by best guess record for domain of brad@chimera) client-ip=173.92.47.29;
// Authentication-Results: mx.google.com;
//        spf=neutral (google.com: 173.92.47.29 is neither permitted nor denied by best guess record for domain of brad@chimera) smtp.mailfrom=brad@chimera;
//        dmarc=fail (p=NONE sp=NONE dis=NONE) header.from=gmail.com
// Received: from chimera (localhost [127.0.0.1]) by chimera (8.15.2/8.15.2/Debian-3) with ESMTP id v47MJTCr022150 for <braddoro@gmail.com>; Sun, 7 May 2017 18:19:29 -0400
// Received: (from brad@localhost) by chimera (8.15.2/8.15.2/Submit) id v47MJTvD022009; Sun, 7 May 2017 18:19:29 -0400
// Date: Sun, 7 May 2017 18:19:29 -0400
// Message-Id: <201705072219.v47MJTvD022009@chimera>
// To: braddoro@gmail.com
// Subject: test email
// X-PHP-Originating-Script: 1000:mail.php
// From: homebrewcabrew@gmail.com
// Reply-To: homebrewcabrew@gmail.com
// X-Mailer: PHP/7.0.15-0ubuntu0.16.04.4

// hello, this is a test.

$to      = 'braddoro@gmail.com';
$subject = 'test email';
$message = 'hello, this is a test.';
$headers = 'From: homebrewcabrew@gmail.com' . "\r\n" . 'Reply-To: homebrewcabrew@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'Return-Path: brad@chimera.icd';
mail($to, $subject, $message, $headers);
?>
