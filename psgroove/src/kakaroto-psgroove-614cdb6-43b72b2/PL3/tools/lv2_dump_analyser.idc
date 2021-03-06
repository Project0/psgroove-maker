/*
 * lv2_dump_analyser.idc -- Analyzes a PS3 LV2 dump in IDA.
 *
 * Copyright (C) Youness Alaoui (KaKaRoTo)
 * Copyright (C) (makeclean)
 *
 * This software is distributed under the terms of the GNU General Public
 * License ("GPL") version 3, as published by the Free Software Foundation.
 *
 */

#include <idc.idc>
#include "idc.idc"


static get_hvcall_rawname(num)
{
        if(     num ==   0) return "allocate_memory";
        else if(num ==   1) return "write_htab_entry";
        else if(num ==   2) return "construct_virtual_address_space";
        else if(num ==   3) return "invalidate_htab_entries";
        else if(num ==   4) return "get_virtual_address_space_id_of_ppe";
        else if(num ==   5) return "undocumented_function_5";
        else if(num ==   6) return "query_logical_partition_address_region_info";
        else if(num ==   7) return "select_virtual_address_space";
        else if(num ==   8) return "undocumented_function_8";
        else if(num ==   9) return "pause";
        else if(num ==  10) return "destruct_virtual_address_space";
        else if(num ==  11) return "configure_irq_state_bitmap";
        else if(num ==  12) return "connect_irq_plug_ext";
        else if(num ==  13) return "release_memory";
        else if(num ==  15) return "put_iopte";
        else if(num ==  16) return "peek";
        else if(num ==  17) return "disconnect_irq_plug_ext";
        else if(num ==  18) return "construct_event_receive_port";
        else if(num ==  19) return "destruct_event_receive_port";
        else if(num ==  20) return "poke";
        else if(num ==  24) return "send_event_locally";
        else if(num ==  26) return "detect_pending_interrupts";
        else if(num ==  27) return "end_of_interrupt";
        else if(num ==  28) return "connect_irq_plug";
        else if(num ==  29) return "disconnect_irq_plug";
        else if(num ==  30) return "end_of_interrupt_ext";
        else if(num ==  31) return "did_update_interrupt_mask";
        else if(num ==  44) return "shutdown_logical_partition";
        else if(num ==  54) return "destruct_logical_spe";
        else if(num ==  57) return "construct_logical_spe";
        else if(num ==  61) return "set_spe_interrupt_mask";
        else if(num ==  62) return "undocumented_function_62";
        else if(num ==  64) return "set_spe_transition_notifier";
        else if(num ==  65) return "disable_logical_spe";
        else if(num ==  66) return "clear_spe_interrupt_status";
        else if(num ==  67) return "get_spe_interrupt_status";
        else if(num ==  69) return "get_logical_ppe_id";
        else if(num ==  73) return "set_interrupt_mask";
        else if(num ==  74) return "get_logical_partition_id";
        else if(num ==  75) return "undocumented_function_75";
        else if(num ==  77) return "configure_execution_time_variable";
        else if(num ==  78) return "get_spe_irq_outlet";
        else if(num ==  79) return "set_spe_privilege_state_area_1_register";
        else if(num ==  89) return "undocumented_function_89";
        else if(num ==  90) return "create_repository_node";
        else if(num ==  91) return "get_repository_node_value";
        else if(num ==  92) return "modify_repository_node_value";
        else if(num ==  93) return "remove_repository_node";
        else if(num ==  95) return "read_htab_entries";
        else if(num ==  96) return "set_dabr";
        else if(num ==  97) return "set_vmx_graphics_mode";
        else if(num ==  98) return "set_thread_switch_control_register";
        else if(num ==  99) return "undocumented_function_99";
        else if(num == 102) return "undocumented_function_102";
        else if(num == 105) return "undocumented_function_105";
        else if(num == 106) return "undocumented_function_106";
        else if(num == 107) return "undocumented_function_107";
        else if(num == 108) return "undocumented_function_108";
        else if(num == 109) return "undocumented_function_109";
        else if(num == 110) return "undocumented_function_110";
        else if(num == 111) return "undocumented_function_111";
        else if(num == 112) return "undocumented_function_112";
        else if(num == 114) return "undocumented_function_114";
        else if(num == 115) return "undocumented_function_115";
        else if(num == 116) return "allocate_io_segment";
        else if(num == 117) return "release_io_segment";
        else if(num == 118) return "allocate_ioid";
        else if(num == 119) return "release_ioid";
        else if(num == 120) return "construct_io_irq_outlet";
        else if(num == 121) return "destruct_io_irq_outlet";
        else if(num == 122) return "map_htab";
        else if(num == 123) return "unmap_htab";
        else if(num == 124) return "undocumented_function_124";
        else if(num == 125) return "undocumented_function_125";
        else if(num == 126) return "undocumented_function_126";
        else if(num == 127) return "get_version_info";
        else if(num == 134) return "undocumented_function_134";
        else if(num == 135) return "undocumented_function_135";
        else if(num == 136) return "undocumented_function_136";
        else if(num == 137) return "undocumented_function_137";
        else if(num == 138) return "undocumented_function_138";
        else if(num == 140) return "construct_lpm";
        else if(num == 141) return "destruct_lpm";
        else if(num == 142) return "start_lpm";
        else if(num == 143) return "stop_lpm";
        else if(num == 144) return "copy_lpm_trace_buffer";
        else if(num == 145) return "add_lpm_event_bookmark";
        else if(num == 146) return "delete_lpm_event_bookmark";
        else if(num == 147) return "set_lpm_interrupt_mask";
        else if(num == 148) return "get_lpm_interrupt_status";
        else if(num == 149) return "set_lpm_general_control";
        else if(num == 150) return "set_lpm_interval";
        else if(num == 151) return "set_lpm_trigger_control";
        else if(num == 152) return "set_lpm_counter_control";
        else if(num == 153) return "set_lpm_group_control";
        else if(num == 154) return "set_lpm_debug_bus_control";
        else if(num == 155) return "set_lpm_counter";
        else if(num == 156) return "set_lpm_signal";
        else if(num == 157) return "set_lpm_spr_trigger";
        else if(num == 158) return "insert_htab_entry";
        else if(num == 162) return "read_virtual_uart";
        else if(num == 163) return "write_virtual_uart";
        else if(num == 164) return "set_virtual_uart_param";
        else if(num == 165) return "get_virtual_uart_param";
        else if(num == 166) return "configure_virtual_uart_irq";
        else if(num == 167) return "undocumented_function_167";
        else if(num == 168) return "undocumented_function_168";
        else if(num == 170) return "open_device";
        else if(num == 171) return "close_device";
        else if(num == 172) return "map_device_mmio_region";
        else if(num == 173) return "unmap_device_mmio_region";
        else if(num == 174) return "allocate_device_dma_region";
        else if(num == 175) return "free_device_dma_region";
        else if(num == 176) return "map_device_dma_region";
        else if(num == 177) return "unmap_device_dma_region";
        else if(num == 178) return "read_pci_config";
        else if(num == 179) return "write_pci_config";
        else if(num == 180) return "read_pci_io";
        else if(num == 181) return "write_pci_io";
        else if(num == 182) return "undocumented_function_182";
        else if(num == 183) return "undocumented_function_183";
        else if(num == 185) return "net_add_multicast_address";
        else if(num == 186) return "net_remove_multicast_address";
        else if(num == 187) return "net_start_tx_dma";
        else if(num == 188) return "net_stop_tx_dma";
        else if(num == 189) return "net_start_rx_dma";
        else if(num == 190) return "net_stop_rx_dma";
        else if(num == 191) return "net_set_interrupt_status_indicator";
        else if(num == 193) return "net_set_interrupt_mask";
        else if(num == 194) return "net_control";
        else if(num == 195) return "undocumented_function_195";
        else if(num == 196) return "undocumented_function_196";
        else if(num == 197) return "connect_interrupt_event_receive_port";
        else if(num == 198) return "disconnect_interrupt_event_receive_port";
        else if(num == 199) return "get_spe_all_interrupt_statuses";
        else if(num == 200) return "undocumented_function_200";
        else if(num == 201) return "undocumented_function_201";
        else if(num == 202) return "deconfigure_virtual_uart_irq";
        else if(num == 207) return "enable_logical_spe";
        else if(num == 209) return "undocumented_function_209";
        else if(num == 210) return "gpu_open";
        else if(num == 211) return "gpu_close";
        else if(num == 212) return "gpu_device_map";
        else if(num == 213) return "gpu_device_unmap";
        else if(num == 214) return "gpu_memory_allocate";
        else if(num == 216) return "gpu_memory_free";
        else if(num == 217) return "gpu_context_allocate";
        else if(num == 218) return "gpu_context_free";
        else if(num == 221) return "gpu_context_iomap";
        else if(num == 222) return "undocumented_function_222";
        else if(num == 225) return "gpu_context_attribute";
        else if(num == 227) return "gpu_context_intr";
        else if(num == 228) return "gpu_attribute";
        else if(num == 231) return "undocumented_function_231";
        else if(num == 232) return "get_rtc";
        else if(num == 233) return "undocumented_function_233";
        else if(num == 240) return "set_ppe_periodic_tracer_frequency";
        else if(num == 241) return "start_ppe_periodic_tracer";
        else if(num == 242) return "stop_ppe_periodic_tracer";
        else if(num == 243) return "undocumented_function_243";
        else if(num == 244) return "undocumented_function_244";
        else if(num == 245) return "storage_read";
        else if(num == 246) return "storage_write";
        else if(num == 248) return "storage_send_device_command";
        else if(num == 249) return "storage_get_async_status";
        else if(num == 250) return "undocumented_function_250";
        else if(num == 251) return "undocumented_function_251";
        else if(num == 252) return "undocumented_function_252";
        else if(num == 253) return "undocumented_function_253";
        else if(num == 254) return "storage_check_async_status";
        else if(num == 255) return "panic";
        else
                            return form("undocumented_function_%d", num);
}

static get_lv2_rawname(num)
{
        if(     num ==   0) return "not_implemented";
        else if(num == 801) return "open";
        else if(num == 802) return "read";
        else if(num == 803) return "write";
        else if(num == 804) return "close";
        else if(num == 805) return "opendir";
        else if(num == 806) return "readdir";
        else if(num == 807) return "closedir";
        else if(num == 808) return "stat";
        else if(num == 809) return "fstat";
        else if(num == 810) return "link";
        else if(num == 811) return "mkdir";
        else if(num == 812) return "rename";
        else if(num == 813) return "rmdir";
        else if(num == 814) return "unlink";
        else if(num == 815) return "utime";
        else if(num == 818) return "lseek";
        else if(num == 820) return "fsync";
        else if(num == 831) return "truncate";
        else if(num == 832) return "ftruncate";
        else if(num == 834) return "chmod";
        else
	                    return form ("%d", num);
}


static NameHypercalls(void) {
  auto addr, ea, num, lookup, total;

  total=0;
  Message("Looking for hypercalls.. \n");
  Message("This will take some time, please wait... \n");

  for ( ea = 0; ea != 0x800000 && ea != BADADDR;) {
    ea = FindBinary(ea, 1, "44 00 00 22");
    if (ea == BADADDR)
      break;

    num = -1;
    for (lookup = 1; lookup < 48 && num == -1; lookup++) {
      addr = ea - (lookup * 4);
      /* Verify if it's a 'li %r11, XX' instruction */
      if ((Dword(addr) & 0xFFFFFF00) == 0x39600000) {
	num = Dword(addr) & 255;
	break;
      }
    }

    if (num == -1) {
      Message("Failed to find hypercall id at offset 0x%06X\n", ea);
    } else {
      total++;
      MakeComm(ea, form("hvsc(%d): lv1_%s", num, get_hvcall_rawname(num)));
    }
    ea = ea + 4;
  }

  Message("\n*** Finished marking hypercalls. Found %d !\n", total);
}

static CreateOpdStructure(void) {
  auto id;

  Message("Creating structure OPD_s\n");

  id = GetStrucIdByName("OPD_s");
  if (id != -1) {
    Message("Structure OPD_s already exists. Renaming it\n");
    if (SetStrucName(id, "OPD_s_renamed") == 0) {
      Message("Structure OPD_s_renamed already exists. deleting existing structure\n");
      DelStruc(id);
    }
    id = -1;
  }
  id = AddStrucEx(-1, "OPD_s", 0);
  if (id == -1) {
    Message ("Error creating OPD_S structure\n");
    return 0;
  }
  AddStrucMember(id, "base_addr_sub", 0x00, FF_DWRD | FF_DATA, -1, 4);
  AddStrucMember(id, "sub", 0x04, FF_DWRD | FF_0OFF, 0, 4);
  AddStrucMember(id, "base_addr_toc", 0x08, FF_DWRD | FF_DATA, -1, 4);
  AddStrucMember(id, "toc", 0x0C, FF_DWRD | FF_0OFF, 0, 4);
  AddStrucMember(id, "env", 0x10, FF_QWRD | FF_DATA, -1, 8);


  return 1;
}


static CreateOpd (toc_addr) {
  auto ea, func;

  CreateOpdStructure();

  MakeName(toc_addr, "TOC");

  Message("Defining OPD section entries\n");

  ea = toc_addr - 0x8000;
  /* Find last OPD entry */
  while (ea != BADADDR && Dword(ea - 0xC) != toc_addr) {
    ea = ea - 0x04;
  }

  while (ea != BADADDR && Dword(ea - 0xC) == toc_addr) {
    ea = ea - 0x18;
    MakeUnknown(ea, 0x18, DOUNK_SIMPLE);
    MakeStructEx (ea, 0x18, "OPD_s");
    func = Dword(ea + 0x4);
    MakeFunction(func, BADADDR);
  }
}


static CreateTocStructure(void) {
  auto id;

  Message("Creating structure TOC_s\n");

  id = GetStrucIdByName("TOC_s");
  if (id != -1) {
    Message("Structure TOC_s already exists. Renaming it\n");
    if (SetStrucName(id, "TOC_s_renamed") == 0) {
      Message("Structure TOC_s_renamed already exists. deleting existing structure\n");
      DelStruc(id);
    }
    id = -1;
  }
  id = AddStrucEx(-1, "TOC_s", 0);
  if (id == -1) {
    Message ("Error creating TOC_S structure\n");
    return 0;
  }
  AddStrucMember(id, "base_addr_toc", 0x00, FF_DWRD | FF_DATA, -1, 4);
  AddStrucMember(id, "toc", 0x04, FF_DWRD | FF_0OFF, 0, 4);

  return 1;
}


static CreateToc (toc_addr) {
  auto ea;

  CreateTocStructure();

  MakeName(toc_addr, "TOC");

  Message("Defining TOC entries\n");

  ea = toc_addr - 0x8000;
  while (ea != toc_addr + 0x8000) {
    MakeUnknown(ea, 0x10, DOUNK_SIMPLE);
    MakeStructEx (ea, 0x10, "TOC_s");
    ea = ea + 0x10;
  }
}


static isSyscallTable(addr) {
    if (Qword(addr + 8*1) != Qword(addr) &&
	Qword(addr + 8*2) != Qword(addr) &&
	Qword(addr + 8*3) != Qword(addr) &&
	Qword(addr + 8*14) != Qword(addr) &&
	Qword(addr + 8*15) == Qword(addr) &&
	Qword(addr + 8*16) == Qword(addr) &&
	Qword(addr + 8*17) == Qword(addr) &&
	Qword(addr + 8*18) != Qword(addr) &&
	Qword(addr + 8*19) != Qword(addr) &&
	Qword(addr + 8*20) == Qword(addr) &&
	Qword(addr + 8*21) != Qword(addr) &&
	Qword(addr + 8*31) != Qword(addr) &&
	Qword(addr + 8*32) == Qword(addr) &&
	Qword(addr + 8*33) == Qword(addr) &&
	Qword(addr + 8*41) != Qword(addr) &&
	Qword(addr + 8*42) == Qword(addr) &&
	Qword(addr + 8*43) != Qword(addr)) {
      return 1;
    } else {
      return 0;
    }
}


static FindSyscallTable(void) {
  auto ea, syscall_table;

  syscall_table = AskAddr(BADADDR, "If you know the location of the syscall table, "
			  "please enter it.\nOtherwise, press Cancel :");

  if (syscall_table != BADADDR) {
    if (isSyscallTable(syscall_table) == 1) {
      Message ("Entered syscall table seems valid, proceding..\n");
    } else {
      Message ("Entered syscall table seems invalid. Will search instead\n");
      syscall_table = BADADDR;
    }
  }
  if (syscall_table == BADADDR) {
    Message("Looking for syscall table.. \n");
    Message("This will take some time, please wait... \n");
    for (ea = 0x400000; ea != 0 && ea != BADADDR; ea = ea - 8 ) {
      if ((ea & 0xffff) == 0)
	Message ("Currently at 0x%x\n", ea);
      if (isSyscallTable(ea)) {
	Message ("\n*** Found syscall table at offset 0x%X\n", ea);
	syscall_table = ea;
	break;
      }
    }
    if (syscall_table == BADADDR) {
      Message ("Could not find syscall table in the first 4MB, trying higher memory\n");
      for (ea = 0x400000; ea != 0x800000 && ea != BADADDR; ea = ea + 8 ) {
	if ((ea & 0xffff) == 0)
	  Message ("Currently at 0x%x\n", ea);
	if (isSyscallTable(ea)) {
	  Message ("\n*** Found syscall table at offset 0x%X\n", ea);
	  syscall_table = ea;
	  break;
	}
      }
    }
  }

  return syscall_table;
}

static CreateSyscallTable(syscall_table) {
  auto i, name, syscall_desc, syscall;

  MakeName(syscall_table, "syscall_table");

  Message ("Naming syscall elements\n");

  /* Search last to first to get the not_implemented syscall named correctly as sc0 */
  for (i = 1023; i != -1; i-- )
  {
    name = get_lv2_rawname(i);

    MakeData(syscall_table + 8 * i, FF_DWRD, 4, 0);
    MakeData(syscall_table + 8 * i + 4, FF_DWRD, 4, 0);
    MakeComm(syscall_table + 8 * i + 4, form("Syscall %d", i));
    syscall_desc = Dword(syscall_table + 8 * i + 4);

    MakeData(syscall_desc, FF_DWRD, 4, 0);
    MakeData(syscall_desc + 4, FF_DWRD, 4, 0);
    MakeName(syscall_desc, form("syscall_%s_desc", name));
    syscall = Dword(syscall_desc + 4);
    MakeFunction (syscall, BADADDR);
    MakeName(syscall, form("syscall_%s", name));
  }
}

static main() {
  auto syscall_table, toc;

  syscall_table = FindSyscallTable();

  if (syscall_table == BADADDR) {
    Message ("Could not find the syscall table\n");
    return;
  }

  CreateSyscallTable(syscall_table);

  /* Each syscall entry is a TOC entry, so get the toc pointer stored in it */
  toc = Dword(Dword(syscall_table + 0x04) + 0xC);

  if (toc == BADADDR) {
    Message ("Could not find the TOC\n");
    return;
  }

  Message (form("\n*** Found TOC at : 0x%X\n", toc));
  CreateToc(toc);
  CreateOpd(toc);

  NameHypercalls();

  Message ("\n*** All done!!\n");
  Message (form("*** Found syscall table at : 0x%X and labeled 'syscall_table'\n", syscall_table));
  Message (form("*** Found TOC at : 0x%X and labeled 'TOC'\n", toc));
  Message ("*** Don't forget to go to Options->General->Analys\n");
  Message ("*** Then click on the 'Processor specific analysis options' button\n");
  Message (form("*** And set the TOC address to 0x%X (or simply to the symbol 'TOC')\n", toc));

  return;
}
