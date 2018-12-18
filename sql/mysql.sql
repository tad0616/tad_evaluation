CREATE TABLE `tad_evaluation` (
  `evaluation_sn` smallint(6) unsigned NOT NULL auto_increment COMMENT '評鑑編號',
  `evaluation_title` varchar(255) NOT NULL default '' COMMENT '評鑑名稱',
  `evaluation_description` text NOT NULL COMMENT '評鑑說明',
  `evaluation_enable` enum('1','0') NOT NULL COMMENT '是否啟用',
  `evaluation_uid` mediumint(8) unsigned NOT NULL default '0' COMMENT '建立者',
  `evaluation_date` datetime NOT NULL COMMENT '建立日期',
PRIMARY KEY (`evaluation_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tad_evaluation_cate` (
  `cate_sn` smallint(6) unsigned NOT NULL COMMENT '分類編號',
  `evaluation_sn` smallint(6) unsigned NOT NULL default '0' COMMENT '評鑑編號',
  `of_cate_sn` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父分類',
  `cate_title` varchar(255) NOT NULL DEFAULT '' COMMENT '分類名稱',
  `cate_desc` text NOT NULL COMMENT '分類說明',
  `cate_sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '分類排序',
  `cate_enable` enum('1','0') NOT NULL COMMENT '開放觀看',
  PRIMARY KEY (`cate_sn`,`evaluation_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tad_evaluation_files` (
  `file_sn` mediumint(9) unsigned NOT NULL COMMENT '檔案編號',
  `cate_sn` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '所屬分類',
  `evaluation_sn` smallint(5) unsigned NOT NULL COMMENT '評鑑編號',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT '檔名',
  `file_size` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '檔案大小',
  `file_type` varchar(255) NOT NULL DEFAULT '' COMMENT '檔案類型',
  `file_desc` text NOT NULL COMMENT '文件說明',
  `file_enable` enum('1','0') NOT NULL COMMENT '開放觀看',
  `file_sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '順序',
  PRIMARY KEY (`file_sn`,`cate_sn`,`evaluation_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;