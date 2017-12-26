<?php
/**
* Plugin for the psgroove-maker
* @author Richard Hillmann 
*/
if (!defined('_EXEC')) die ("This is a part of the programm");

$psgroove_conf["src"][0] = array(
						"id"=>0,
						"name" => "PSGroove Hermes",
						"version" => "v3",
						"date_release" => "05.10.2010",
						"nfo" => '- incl. Peek and Poke Syscalls 
- incl. Payload (see AerialX Fork)
- Hermes v1: No Blu-Ray-Disc support.
- Hermes v3: Add support for syscall 8. Support for Homebrew in /apps_home/PS3_GAME. Syscall redirection 36 games to run diskless: /apps_home/PS3_GAME. New Address 0x80000000007ff000 end of the payload at the end of the Kernel
 ',
						"src_folder" => "psgroove-hermes-v3",
						"type" => "psgroove_atmel_lufa",
						"exec_make" => 'make clean && make all',
						"makefile_main_tpl" => 'tpl.Makefile.psgroove',
						"makefile_main" => 'Makefile.psgroove',
						"makefile_payload_tpl" => 'tpl.Makefile.payload',
						"makefile_payload" => 'Makefile.payload',
						"flashsize" => 12
);

$psgroove_conf["src"][1] = array(
						"id"=>1,
						"name" => "PSGroove Hermes Waninkoko vpkgdemo",
						"version" => "v3-vpkgdemo",
						"date_release" => "10.10.2010",
						"nfo" => '- incl. Peek and Poke Syscalls 
- incl. Payload (see AerialX Fork)
- Hermes v1: No Blu-Ray-Disc support.
- Hermes v3: Add support for syscall 8. Support for Homebrew in /apps_home/PS3_GAME. Syscall redirection 36 games to run diskless: /apps_home/PS3_GAME. New Address 0x80000000007ff000 end of the payload at the end of the Kernel
- Waninkoko: Retail PKG installation support
 ',
						"src_folder" => "psgroove-hermes-v3-vpkgdemo",
						"type" => "psgroove_atmel_lufa",
						"exec_make" => 'make clean && make all',
						"makefile_main_tpl" => 'tpl.Makefile.psgroove',
						"makefile_main" => 'Makefile.psgroove',
						"makefile_payload_tpl" => 'tpl.Makefile.payload',
						"makefile_payload" => 'Makefile.payload',
						"flashsize" => 12
);

$psgroove_conf["src"][2] = array(
						"id"=>2,
						"name" => "PSGroove Hermes",
						"version" => "v1",
						"date_release" => "21.09.2010",
						"nfo" => '- incl. Peek and Poke Syscalls 
- incl. Payload (see AerialX Fork)
- Hermes v1: No Blu-Ray-Disc support.
 ',
						"src_folder" => "psgroove-hermes-v1",
						"type" => "psgroove_atmel_lufa",
						"exec_make" => 'make clean && make all',
						"makefile_main_tpl" => 'tpl.Makefile.psgroove',
						"makefile_main" => 'Makefile.psgroove',
						"makefile_payload_tpl" => 'tpl.Makefile.payload',
						"makefile_payload" => 'Makefile.payload',
						"flashsize" => 12
);

$psgroove_conf["src"][3] = array(
						"id"=>3,
						"name" => "PSGroove",
						"version" => "1.1",
						"date_release" => "14.09.2010",
						"nfo" => "- patched for Backupmanager compatibility
- incl. Peek and Poke Syscalls ",
						"src_folder" => "meteorfox-psgroove-98c5b35-v1.1",
						"type" => "psgroove_atmel_lufa",
						"exec_make" => 'make clean && make all',
						"makefile_main_tpl" => 'tpl.Makefile.psgroove',
						"makefile_main" => 'Makefile',
						"flashsize" => 12
);

$psgroove_conf["src"][4] = array(
						"id"=>4,
						"name" => "PSGroove Hermes+Waninkoko+Mathieulh (v2 Patch)",
						"version" => "v3-waninkoko-math",
						"date_release" => "15.10.2010",
						"nfo" => '- incl. Peek and Poke Syscalls 
- incl. Payload (see AerialX Fork)
- Hermes v1: No Blu-Ray-Disc support.
- Hermes v3: Add support for syscall 8. Support for Homebrew in /apps_home/PS3_GAME. Syscall redirection 36 games to run diskless: /apps_home/PS3_GAME. New Address 0x80000000007ff000 end of the payload at the end of the Kernel
- Waninkoko+Mathieulh: Retail PKG installation support + Game Updates fix
',
						"src_folder" => "psgroove-hermes-v3-Waninkoko-2_Fix_Update_Math",
						"type" => "psgroove_atmel_lufa",
						"exec_make" => 'make clean && make all',
						"makefile_main_tpl" => 'tpl.Makefile.psgroove',
						"makefile_main" => 'Makefile.psgroove',
						"makefile_payload_tpl" => 'tpl.Makefile.payload',
						"makefile_payload" => 'Makefile.payload',
						"flashsize" => 12
);

$psgroove_conf["src"][5] = array(
						"id"=>5,
						"name" => "PSGroove Hermes",
						"version" => "v4b (final)",
						"date_release" => "16.10.2010",
						"nfo" => 'Hermes 4 and 4b are same here. Its only a windows relevated change of the raw2payload tool.
						- incl. Peek and Poke Syscalls 
- incl. Payload (see AerialX Fork)
- Hermes v1: No Blu-Ray-Disc support.
- Hermes v3: Add support for syscall 8. Support for Homebrew in /apps_home/PS3_GAME. Syscall redirection 36 games to run diskless: /apps_home/PS3_GAME. New Address 0x80000000007ff000 end of the payload at the end of the Kernel
- Hermes v4: update latest patches.
',
						"src_folder" => "psgroove-hermes-v4",
						"type" => "psgroove_atmel_lufa",
						"exec_make" => 'make clean && make all',
						"makefile_main_tpl" => 'tpl.Makefile.psgroove',
						"makefile_main" => 'Makefile.psgroove',
						"makefile_payload_tpl" => 'tpl.Makefile.payload',
						"makefile_payload" => 'Makefile.payload',
						"flashsize" => 12
);

$psgroove_conf["src"][6] = array(
						"id"=>6,
						"name" => "PSGroove KaKaRoTo PL3",
						"version" => "Tree: <b>614cdb6</b> \n<br/> PL3-Tree: <b>74d294f</b>",
						"date_release" => "17.10.2010",
						"nfo" => 'KaKaRoTo PL3 release. 
							- Main tree: 614cdb6e7d2d5bc400b39b5bd9585cba43ab80d6
							- PL3 tree:  74d294fe14610060ddb903a209ecd90b35daf799
',
						"src_folder" => "kakaroto-psgroove-614cdb6",
						"type" => "psgroove_atmel_lufa",
						"exec_make" => 'make clean && make all',
						"makefile_main_tpl" => 'tpl.Makefile.psgroove',
						"makefile_main" => 'Makefile',
						"makefile_payload_tpl" => 'PL3'.DS.'tpl.Makefile_pl3',
						"makefile_payload" => 'PL3'.DS.'Makefile',
						"flashsize" => 12,
						"pl3_firmware" => array("3_41","3_15","3_10","3_01")
);

$psgroove_conf["src"][7] = array(
						"id"=>7,
						"name" => "PSGroove KaKaRoTo PL3",
						"version" => "Tree: <b>614cdb6</b> \n<br/> PL3-Tree: <b>43b72b2</b>",
						"date_release" => "23.10.2010",
						"nfo" => 'KaKaRoTo PL3 release. 
							- PL3 Payload: 80010019 Error Fix (MOH, no update needed)
							- PL3 Payload: Add a payload that disables the patch for unauthorized syscalls (patched mode).
							- Main tree: 614cdb6e7d2d5bc400b39b5bd9585cba43ab80d6
							- PL3 tree:  43b72b2a6889d265a790b62e46f142f550688f57						
',
						"src_folder" => "kakaroto-psgroove-614cdb6-43b72b2",
						"type" => "psgroove_atmel_lufa",
						"exec_make" => 'make clean && make all',
						"makefile_main_tpl" => 'tpl.Makefile.psgroove',
						"makefile_main" => 'Makefile',
						"makefile_payload_tpl" => 'PL3'.DS.'tpl.Makefile_pl3',
						"makefile_payload" => 'PL3'.DS.'Makefile',
						"flashsize" => 12,
						"pl3_firmware" => array("3_41", "3_15","3_10","3_01")
);
$psgroove_conf["src"][9] = array(
                                                "id"=>9,
                                                "name" => "PSGroove Hermes PSN",
                                                "version" => "v4b-PSN",
                                                "date_release" => "10.11.2010",
                                                "nfo" => 'Hermes v4 with PSN Payload',
                                                "src_folder" => "psgroove-hermes-v4-psn",
                                                "type" => "psgroove_atmel_lufa",
                                                "exec_make" => 'make clean && make all',
                                                "makefile_main_tpl" => 'tpl.Makefile.psgroove',
                                                "makefile_main" => 'Makefile.psgroove',
                                                "makefile_payload_tpl" => 'tpl.Makefile.payload',
                                                "makefile_payload" => 'Makefile.payload',
                                                "flashsize" => 12
);
$psgroove_conf["src"][10] = array(
                                                "id"=>10,
                                                "name" => "PSGroove Hermes PSN",
                                                "version" => "v4b-PSN+mathfix",
                                                "date_release" => "11.11.2010",
                                                "nfo" => 'Hermes v4 with PSN Payload AND Mathieulh Fix',
                                                "src_folder" => "psgroove-hermes-v4-psn-mathfix",
                                                "type" => "psgroove_atmel_lufa",
                                                "exec_make" => 'make clean && make all',
                                                "makefile_main_tpl" => 'tpl.Makefile.psgroove',
                                                "makefile_main" => 'Makefile.psgroove',
                                                "makefile_payload_tpl" => 'tpl.Makefile.payload',
                                                "makefile_payload" => 'Makefile.payload',
                                                "flashsize" => 12
);
$psgroove_conf["src"][11] = array(
                                                "id"=>11,
                                                "name" => "PSGroove evilsperm PL3",
                                                "version" => "Tree: <b>e4133c3</b> \n<br/> PL3-Tree: <b>d5ee025</b>",
						"date_release" => "15.11.2010",
                                                "nfo" => 'evilsperm sources. With PSN Payload(mathfix) and 3.50 spoofing.                                    
						
',
                                                "src_folder" => "evilsperm-psgroove-e4133c3-d5ee025",
                                                "type" => "psgroove_atmel_lufa",
                                                "exec_make" => 'make clean && make all',
                                                "makefile_main_tpl" => 'tpl.Makefile.psgroove',
                                                "makefile_main" => 'Makefile',
                                                "makefile_payload_tpl" => 'PL3'.DS.'tpl.Makefile_pl3',
                                                "makefile_payload" => 'PL3'.DS.'Makefile',
                                                "flashsize" => 12,
                                                "pl3_firmware" => array("3_41")
);

$psgroove_conf["src"][12] = array(
                                                "id"=>12,
                                                "name" => "PSGroove PL3",
                                                "version" => "Tree: <b>80aa7f8</b> (superg) \n<br/> PL3-Tree: <b>e10bf98</b> (kakaroto)",
												"date_release" => "28.12.2010",
                                                "nfo" => 'Latest PSGroove with PL3 default Payload.
												Optional AutoDFU Mode. 
												No Firmware spoofing.                               
						
',
                                                "src_folder" => "superg-psgroove-80aa7f8-e10bf98",
                                                "type" => "psgroove_atmel_lufa",
                                                "exec_make" => 'make clean && make all',
                                                "makefile_main_tpl" => 'tpl.Makefile.psgroove',
                                                "makefile_main" => 'Makefile',
                                                "makefile_payload_tpl" => 'PL3'.DS.'tpl.Makefile_pl3',
                                                "makefile_payload" => 'PL3'.DS.'Makefile',
                                                "flashsize" => 12,
                                                "pl3_firmware" => array("3_41", "3_41_KIOSK", "3_40", "3_30", "3_21",  "3_15", "3_10", "3_01", "2_76", "2_70", "2_60", "2_53", "2_43"),
												"pl3_payload_type" => array("default_payload", "payload_dev", "payload_no_unauth_syscall", "payload_dump_elfs", "payload_trace_syscalls", "payload_trace_hypercalls", "payload_trace_all_sc_calls", "payload_trace_vuart"),
												"descriptor_tpl" => "tpl.descriptor",
												"descriptor" => "descriptor.h",
												"dfu_auto" => true,
												"dfu_auto_tpl_src" => "tpl.psgroove.dfuauto.c",
												"dfu_auto_tpl_orig" => "tpl.psgroove.c",
												"dfu_auto_tpl_dest" => "psgroove.c"
);

$psgroove_conf["src"][13] = array(
                                                "id"=>13,
                                                "name" => "PSGrade - Downgrade",
                                                "version" => "Tree: <b>e51e811</b> (Noltari) ",
												"date_release" => "29.12.2010",
                                                "nfo" => 'Noltari sources. Enables downgrading of the Firmware from 3.50.  						
',
                                                "src_folder" => "Noltari-PSGrade-e51e811",
                                                "type" => "psgroove_atmel_lufa",
                                                "exec_make" => 'make clean && make all',
                                                "makefile_main_tpl" => 'tpl.Makefile.psgrade',
                                                "makefile_main" => 'Makefile',
                                                "flashsize" => 12,
                                                "file_name" => "psgrade.hex",
												"dfu_auto" => true,
												"dfu_auto_tpl_src" => "tpl.psgrade.dfuauto.c",
												"dfu_auto_tpl_orig" => "tpl.psgrade.c",
												"dfu_auto_tpl_dest" => "psgrade.c"
);

$psgroove_conf["src"][14] = array(
                                                "id"=>14,
                                                "name" => "PSGroove Hermes PSN",
                                                "version" => "v4b-PSN+mathfix<br/>3.55 spoof",
                                                "date_release" => "15.12.2010",
                                                "nfo" => 'Hermes v4 with PSN Payload AND Mathieulh Fix. 3.55 Spoofing',
                                                "src_folder" => "psgroove-hermes-v4-psn-mathfix-355",
                                                "type" => "psgroove_atmel_lufa",
                                                "exec_make" => 'make clean && make all',
                                                "makefile_main_tpl" => 'tpl.Makefile.psgroove',
                                                "makefile_main" => 'Makefile.psgroove',
                                                "makefile_payload_tpl" => 'tpl.Makefile.payload',
                                                "makefile_payload" => 'Makefile.payload',
                                                "flashsize" => 12,
												"dfu_auto" => true,
												"dfu_auto_tpl_src" => "tpl.psgroove.dfuauto.c",
												"dfu_auto_tpl_orig" => "tpl.psgroove.c",
												"dfu_auto_tpl_dest" => "psgroove.c"
);


$psgroove_conf["src"][15] = array(
                                                "id"=>15,
                                                "name" => "PSGroove evilsperm PL3",
                                                "version" => "Tree: <b>e4133c3</b> PL3: 3.55 spoof\n<br/> ",
						"date_release" => "15.12.2010",
                                                "nfo" => 'evilsperm sources. With PSN Payload(mathfix) and 3.55 spoofing.                                    
						
',
                                                "src_folder" => "evilsperm-psgroove-e4133c3-355",
                                                "type" => "psgroove_atmel_lufa",
                                                "exec_make" => 'make clean && make all',
                                                "makefile_main_tpl" => 'tpl.Makefile.psgroove',
                                                "makefile_main" => 'Makefile',
                                                "makefile_payload_tpl" => 'PL3'.DS.'tpl.Makefile_pl3',
                                                "makefile_payload" => 'PL3'.DS.'Makefile',
                                                "flashsize" => 12,
                                                "pl3_firmware" => array("3_41"),
												"pl3_payload_type" => array("default_payload", "payload_dev", "payload_no_unauth_syscall",  "payload_dump_elfs"),
												"descriptor_tpl" => "tpl.descriptor",
												"descriptor" => "descriptor.h",
												"dfu_auto" => true,
												"dfu_auto_tpl_src" => "tpl.psgroove.dfuauto.c",
												"dfu_auto_tpl_orig" => "tpl.psgroove.c",
												"dfu_auto_tpl_dest" => "psgroove.c"
);


$psgroove_conf["PS3_COMPILERS"] = '/opt/cell/toolchain/bin';
$psgroove_conf["PPU_CC"] = '/ppu-gcc';
$psgroove_conf["PPU_OBJCOPY"] = '/ppu-objcopy';
/*
$psgroove_conf["PS3_COMPILERS"] = '/usr/bin';
$psgroove_conf["PPU_CC"] = '/powerpc64-unknown-linux-gnu-gcc';
$psgroove_conf["PPU_OBJCOPY"] = '/powerpc64-unknown-linux-gnu-objcopy';
*/
?>
