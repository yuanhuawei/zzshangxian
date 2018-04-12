-- <?php exit;?>

CREATE TABLE IF NOT EXISTS`p8_forms_item_banshi` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `bslb` varchar(255) NOT NULL,
  `lxr` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `czsm` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `lianj` varchar(255) DEFAULT NULL,
  `bianhao` varchar(255) DEFAULT NULL,
  `tupian` text,
  `sybumen` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_bmjx` (
  `id` int(10) unsigned NOT NULL,
  `bumen` varchar(255) NOT NULL,
  `fzr` varchar(255) NOT NULL,
  `ztasl` varchar(255) NOT NULL,
  `yuefen` varchar(255) NOT NULL,
  `yxta` varchar(255) DEFAULT NULL,
  `kaoqin` varchar(255) NOT NULL,
  `sksj` varchar(255) NOT NULL,
  `pxsj` int(255) NOT NULL,
  `gzwcd` varchar(255) NOT NULL,
  `zgjl` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_bmtajx` (
  `id` int(10) unsigned NOT NULL,
  `bumen` varchar(255) NOT NULL,
  `bmzg` varchar(255) NOT NULL,
  `yuefen` varchar(255) NOT NULL,
  `tazs` int(10) NOT NULL,
  `yxtas` int(10) NOT NULL,
  `jptas` int(10) unsigned NOT NULL,
  `yptas` int(255) NOT NULL,
  `ybtas` int(255) NOT NULL,
  `zgjx` decimal(10,0) NOT NULL,
  `kaoqin` varchar(255) NOT NULL,
  `qjcs` int(10) NOT NULL,
  `kg` int(10) NOT NULL,
  `late` int(10) NOT NULL,
  `kq` decimal(10,0) NOT NULL,
  `sk` int(255) NOT NULL,
  `px` int(255) NOT NULL,
  `pxjx` int(255) NOT NULL,
  `gz` varchar(255) NOT NULL,
  `tapx` varchar(255) DEFAULT NULL,
  `gzjx` decimal(10,0) NOT NULL,
  `gznr` varchar(255) DEFAULT NULL,
  `pxbx` int(255) NOT NULL,
  `zjx` int(10) NOT NULL,
  `year` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_bom` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `bianhao` varchar(255) NOT NULL,
  `shuliang` varchar(255) NOT NULL,
  `caigou` int(255) NOT NULL,
  `cgny` varchar(255) NOT NULL,
  `kucun` varchar(255) DEFAULT NULL,
  `BOM` varchar(255) NOT NULL,
  `BOMFZR` varchar(255) NOT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `wailian` varchar(255) DEFAULT NULL,
  `mzlx` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_bumengtiang` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `bumeng` varchar(255) NOT NULL,
  `tianmingcheng` varchar(255) NOT NULL,
  `tianneirong` varchar(255) NOT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `zhuguan` varchar(255) NOT NULL,
  `jasj` varchar(255) NOT NULL,
  `tasj` varchar(255) DEFAULT NULL,
  `jianjin` varchar(255) NOT NULL,
  `xiangxi` varchar(255) DEFAULT NULL,
  `yuefen` varchar(255) NOT NULL,
  `tacyr` varchar(255) DEFAULT NULL,
  `bmfzr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_bybd1` (
  `id` int(10) unsigned NOT NULL,
  `xingming` varchar(255) NOT NULL,
  `sshubm` varchar(255) NOT NULL,
  `sfleixing` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `kdgs` varchar(255) NOT NULL,
  `jjcd` varchar(255) NOT NULL,
  `kdnr` varchar(255) DEFAULT NULL,
  `kdzt` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_bybd2` (
  `id` int(10) unsigned NOT NULL,
  `mingcheng` varchar(255) NOT NULL,
  `lxr` varchar(255) NOT NULL,
  `leixing` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `QQ` varchar(255) DEFAULT NULL,
  `dizhi` varchar(255) DEFAULT NULL,
  `wangzhi` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_bybd3` (
  `id` int(10) unsigned NOT NULL,
  `xingm` varchar(255) NOT NULL,
  `zbmc` varchar(255) NOT NULL,
  `zxzt` varchar(255) NOT NULL,
  `dt` varchar(255) NOT NULL,
  `sxbh` varchar(255) NOT NULL,
  `xqbz` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_bybd4` (
  `id` int(10) unsigned NOT NULL,
  `tibaoren` varchar(255) NOT NULL,
  `chengdu` varchar(255) NOT NULL,
  `baoxsx` varchar(255) NOT NULL,
  `bxjtnr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_bybd6` (
  `id` int(10) unsigned NOT NULL,
  `baofei` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `cplx` varchar(255) NOT NULL,
  `cpmc` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `hgcp` varchar(255) DEFAULT NULL,
  `nianfen` varchar(255) NOT NULL,
  `sjsl` varchar(255) NOT NULL,
  `tibaoren` varchar(255) NOT NULL,
  `yuefen` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_bybd7` (
  `id` int(10) unsigned NOT NULL,
  `xingming` varchar(255) NOT NULL,
  `bumen` varchar(255) NOT NULL,
  `chidao` int(10) NOT NULL,
  `kgcs` int(10) NOT NULL,
  `qjsj` int(10) NOT NULL,
  `nianfen` varchar(255) NOT NULL,
  `moth` varchar(255) NOT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_caigougongzhang` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `gongzhangleixing` varchar(255) NOT NULL,
  `bianhao` varchar(255) NOT NULL,
  `hetongmingcheng` varchar(255) NOT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `cpin` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_canpinjc` (
  `id` int(10) unsigned NOT NULL,
  `wuliao` varchar(255) NOT NULL,
  `bianhao` varchar(255) DEFAULT NULL,
  `gongju` varchar(255) NOT NULL,
  `zhibiao` varchar(255) NOT NULL,
  `xiangxi` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `yichang` text,
  `jiancr` varchar(255) NOT NULL,
  `tebbzh` varchar(255) DEFAULT NULL,
  `wailian` varchar(255) DEFAULT NULL,
  `leibie` varchar(255) NOT NULL,
  `cheliang` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_cgbbd` (
  `id` int(10) unsigned NOT NULL,
  `nmae` varchar(255) NOT NULL,
  `sxmc` varchar(255) NOT NULL,
  `xqbz` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `banji` varchar(255) NOT NULL,
  `shouji` varchar(255) NOT NULL,
  `youxiang` varchar(255) NOT NULL,
  `xingb` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_cgjhxq` (
  `id` int(10) unsigned NOT NULL,
  `cgwl` varchar(255) NOT NULL,
  `bianma` varchar(255) NOT NULL,
  `shuliang` varchar(255) NOT NULL,
  `jinji` varchar(255) NOT NULL,
  `xuqsj` varchar(255) NOT NULL,
  `xqdh` varchar(255) NOT NULL,
  `spdh` varchar(255) NOT NULL,
  `ytong` varchar(255) DEFAULT NULL,
  `cgzrr` varchar(255) NOT NULL,
  `wlxz` varchar(255) NOT NULL,
  `fenxiang` varchar(255) NOT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_ckbbd` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `sxmc` varchar(255) NOT NULL,
  `bez` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `leix` varchar(255) NOT NULL,
  `zhuantia` varchar(255) NOT NULL,
  `danwei` varchar(255) NOT NULL,
  `shouj` varchar(255) NOT NULL,
  `youxiang` varchar(255) NOT NULL,
  `erer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_ckslfl` (
  `id` int(10) unsigned NOT NULL,
  `wlmc` varchar(255) NOT NULL,
  `wlbm` varchar(255) NOT NULL,
  `cllx` varchar(255) NOT NULL,
  `lianfen` varchar(255) NOT NULL,
  `yufen` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `shgys` varchar(255) DEFAULT NULL,
  `shdh` varchar(255) DEFAULT NULL,
  `shsl` varchar(255) DEFAULT NULL,
  `wlhgsl` varchar(255) DEFAULT NULL,
  `slbz` varchar(255) DEFAULT NULL,
  `linliaoren` varchar(255) DEFAULT NULL,
  `lldh` varchar(255) DEFAULT NULL,
  `llsll` varchar(255) DEFAULT NULL,
  `flbz` varchar(255) DEFAULT NULL,
  `slzj` varchar(255) DEFAULT NULL,
  `flzj` varchar(255) DEFAULT NULL,
  `beizhuxinxi` varchar(255) DEFAULT NULL,
  `fljsr` varchar(255) DEFAULT NULL,
  `sljsr` varchar(255) DEFAULT NULL,
  `xiankucun` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_cttc` (
  `id` int(10) unsigned NOT NULL,
  `ctmc` varchar(255) NOT NULL,
  `tupian` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `tel` varchar(255) NOT NULL,
  `pinbi` varchar(255) NOT NULL,
  `sudu` varchar(255) NOT NULL,
  `dii` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_cwbbd` (
  `id` int(10) unsigned NOT NULL,
  `mane` varchar(255) NOT NULL,
  `ssssss` varchar(255) NOT NULL,
  `xqbb` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `bum` varchar(255) NOT NULL,
  `shouji` varchar(255) NOT NULL,
  `youxiang` varchar(255) NOT NULL,
  `xingb` varchar(255) NOT NULL,
  `riqi` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_cwyb` (
  `id` int(10) unsigned NOT NULL,
  `xingming` varchar(255) NOT NULL,
  `ganwei` varchar(255) NOT NULL,
  `nianfen` varchar(255) NOT NULL,
  `yuefen` varchar(255) NOT NULL,
  `jyzc` int(10) NOT NULL,
  `kdwlzc` int(10) DEFAULT NULL,
  `yfjf` int(10) DEFAULT NULL,
  `gysfk` int(10) DEFAULT NULL,
  `jbgzzc` int(10) DEFAULT NULL,
  `jxzc` int(10) DEFAULT NULL,
  `qita` int(10) DEFAULT NULL,
  `zzhichu` int(10) NOT NULL,
  `zongshouru` int(10) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `shuoming` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_dangweixingzhen` (
  `id` int(10) unsigned NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `keyanchengguo` varchar(255) NOT NULL,
  `lianxiwomen` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shortdesc` varchar(255) NOT NULL,
  `workroom` varchar(255) NOT NULL,
  `yanjiufangxiang` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_dingcang` (
  `id` int(10) unsigned NOT NULL,
  `shengqr` varchar(255) NOT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `canting` varchar(255) NOT NULL,
  `tcbh` varchar(255) DEFAULT NULL,
  `tcmc` varchar(255) DEFAULT NULL,
  `canci` varchar(255) NOT NULL,
  `time` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `fenshu` varchar(255) NOT NULL,
  `dangjia` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_dlxstc` (
  `id` int(10) unsigned NOT NULL,
  `qymc` varchar(255) NOT NULL,
  `lxr` varchar(255) NOT NULL,
  `lxdh` varchar(255) DEFAULT NULL,
  `xiaoshou` decimal(10,0) NOT NULL,
  `tcje` decimal(10,0) NOT NULL,
  `tczf` varchar(255) NOT NULL,
  `tcxq` varchar(255) DEFAULT NULL,
  `fjzl` varchar(255) DEFAULT NULL,
  `nianfen` varchar(255) NOT NULL,
  `yuefen` varchar(255) NOT NULL,
  `ticmm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_gdzc` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `bianhao` varchar(255) NOT NULL,
  `zcfl` varchar(255) NOT NULL,
  `fzr` varchar(255) NOT NULL,
  `gmje` decimal(10,0) NOT NULL,
  `goumsj` varchar(255) NOT NULL,
  `zhuantai` varchar(255) NOT NULL,
  `jhsj` varchar(255) NOT NULL,
  `jcr` varchar(255) NOT NULL,
  `tupian` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `miaosh` varchar(255) DEFAULT NULL,
  `shiyongr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_gongyingshang` (
  `id` int(10) unsigned NOT NULL,
  `gysbianma` varchar(30) NOT NULL,
  `gysjc` varchar(255) NOT NULL,
  `gysqc` varchar(255) NOT NULL,
  `wuliao` varchar(500) NOT NULL,
  `lianxiren` varchar(255) NOT NULL,
  `dianhua` varchar(40) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `gongyingshang` varchar(255) DEFAULT NULL,
  `dizhi` varchar(500) NOT NULL,
  `fuzeren` varchar(255) DEFAULT NULL,
  `zhuceziben` varchar(255) DEFAULT NULL,
  `beizhu` varchar(500) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `yyzz` text,
  `pingshen` varchar(255) DEFAULT NULL,
  `pinshenfzr` varchar(255) DEFAULT NULL,
  `wanzhan` varchar(255) DEFAULT NULL,
  `leibie` varchar(255) NOT NULL,
  `QQ` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_gongzi` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `bumen` varchar(255) NOT NULL,
  `yuefen` varchar(255) NOT NULL,
  `zongz` varchar(0) NOT NULL,
  `jiben` varchar(255) NOT NULL,
  `jxiao` varchar(0) NOT NULL,
  `koukuan` decimal(10,0) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `glycx` varchar(255) NOT NULL,
  `ffrq` varchar(255) NOT NULL,
  `banji` varchar(255) NOT NULL,
  `zzmm` varchar(255) NOT NULL,
  `chus` varchar(255) NOT NULL,
  `xuehao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_gysfk` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bianma` varchar(255) DEFAULT NULL,
  `fukuan` varchar(255) NOT NULL,
  `fuksj` varchar(255) DEFAULT NULL,
  `tijiaore` varchar(255) DEFAULT NULL,
  `fkbeizhu` varchar(255) DEFAULT NULL,
  `tsbt` varchar(255) NOT NULL,
  `tme` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_gzcx` (
  `id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_gzqs` (
  `id` int(10) unsigned NOT NULL,
  `xingming` varchar(255) NOT NULL,
  `bumne` varchar(255) NOT NULL,
  `nianfen` varchar(255) NOT NULL,
  `yuefen` varchar(255) NOT NULL,
  `leixing` varchar(255) NOT NULL,
  `gzff` varchar(255) DEFAULT NULL,
  `yifje` varchar(255) DEFAULT NULL,
  `sfje` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `beizhusm` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_huodongbm` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `bumeng` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `yidong` int(15) unsigned DEFAULT NULL,
  `shixianleb` varchar(255) NOT NULL,
  `xiangxi` varchar(255) DEFAULT NULL,
  `hdmc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_jdbbd` (
  `id` int(10) unsigned NOT NULL,
  `xingming` varchar(255) NOT NULL,
  `smc` varchar(255) NOT NULL,
  `xiangqing` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `sjhm` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `banji` varchar(255) NOT NULL,
  `zzlx` varchar(255) NOT NULL,
  `zhiwei` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_jiangshi` (
  `id` int(10) unsigned NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `keyanchengguo` varchar(255) NOT NULL,
  `lianxiwomen` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shortdesc` varchar(255) NOT NULL,
  `workroom` varchar(255) NOT NULL,
  `yanjiufangxiang` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_jiaoshou` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `yanjiufangxiang` varchar(255) NOT NULL,
  `keyanchengguo` varchar(250) NOT NULL,
  `lianxiwomen` varchar(255) NOT NULL,
  `workroom` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `shortdesc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_jixiaobiaoyan` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `bumeng` varchar(255) NOT NULL,
  `xiangxi` varchar(255) NOT NULL,
  `shoukeshijian` decimal(10,0) DEFAULT NULL,
  `shoukejixiao` decimal(10,0) DEFAULT NULL,
  `shifqq` varchar(255) DEFAULT NULL,
  `chidao` int(255) DEFAULT NULL,
  `kuanggong` int(255) DEFAULT NULL,
  `qingjia` int(255) DEFAULT NULL,
  `qingjiasj` decimal(10,0) DEFAULT NULL,
  `kqjj` decimal(10,0) DEFAULT NULL,
  `kouzhi` decimal(10,0) DEFAULT NULL,
  `tiang` int(255) DEFAULT NULL,
  `yxtas` int(255) DEFAULT NULL,
  `jptas` int(255) DEFAULT NULL,
  `yptas` int(255) DEFAULT NULL,
  `ybtas` int(255) DEFAULT NULL,
  `tajx` decimal(10,0) DEFAULT NULL,
  `pxsjs` decimal(10,0) DEFAULT NULL,
  `pxjx` decimal(10,0) DEFAULT NULL,
  `zongjx` decimal(10,0) DEFAULT NULL,
  `gzwcd` varchar(255) DEFAULT NULL,
  `zxjx` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_kehu` (
  `id` int(10) unsigned NOT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `bum` varchar(255) NOT NULL,
  `caigou` varchar(255) NOT NULL,
  `csny` varchar(255) NOT NULL,
  `czhm` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `date2` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gaokao` varchar(255) NOT NULL,
  `kaoshenghao` varchar(255) NOT NULL,
  `khjb` varchar(255) NOT NULL,
  `khlb` varchar(255) NOT NULL,
  `khmc` varchar(255) NOT NULL,
  `lianxiren` varchar(255) NOT NULL,
  `QQ` varchar(255) DEFAULT NULL,
  `shouji` varchar(255) NOT NULL,
  `tongxing` varchar(255) NOT NULL,
  `wangzhi` varchar(255) DEFAULT NULL,
  `xingmin` varchar(255) NOT NULL,
  `xingming` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `yuefen` varchar(255) NOT NULL,
  `zycj` varchar(255) DEFAULT NULL,
  `zy` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_kehucj` (
  `id` int(10) unsigned NOT NULL,
  `xingming` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `yue` varchar(255) DEFAULT NULL,
  `riqi` varchar(255) NOT NULL,
  `kehumc` varchar(255) NOT NULL,
  `khlxr` varchar(255) DEFAULT NULL,
  `khlxdh` varchar(255) NOT NULL,
  `htbh` varchar(255) NOT NULL,
  `ddnr` varchar(255) DEFAULT NULL,
  `sjcjjg` varchar(255) DEFAULT NULL,
  `fkqk` varchar(255) DEFAULT NULL,
  `mima` int(20) NOT NULL,
  `zhengjhaom` varchar(255) NOT NULL,
  `leixing` varchar(255) NOT NULL,
  `chuanzhen` varchar(255) NOT NULL,
  `yogntu` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_kq` (
  `id` int(10) unsigned NOT NULL,
  `xingming` varchar(255) NOT NULL,
  `bumeng` varchar(255) NOT NULL,
  `nianfen` varchar(255) NOT NULL,
  `yuefen` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `shijan` int(10) NOT NULL,
  `xiangqing` varchar(255) NOT NULL,
  `danghao` varchar(255) DEFAULT NULL,
  `dianh` varchar(255) NOT NULL,
  `yx` varchar(255) NOT NULL,
  `banji` varchar(255) NOT NULL,
  `jiezshj` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_mimaxiugai` (
  `id` int(10) unsigned NOT NULL,
  `xingming` varchar(255) NOT NULL,
  `bumne` varchar(255) NOT NULL,
  `leixing` varchar(255) NOT NULL,
  `jiumim` varchar(255) DEFAULT NULL,
  `xinmima` varchar(255) NOT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_paiban` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `bumeng` varchar(255) NOT NULL,
  `neirong` varchar(255) NOT NULL,
  `leixing` varchar(255) NOT NULL,
  `xiangqing` varchar(255) DEFAULT NULL,
  `renshu` varchar(255) NOT NULL,
  `xingqi` varchar(255) DEFAULT NULL,
  `lianjie` varchar(255) DEFAULT NULL,
  `zbrq` varchar(255) NOT NULL,
  `sxbh` varchar(255) NOT NULL,
  `fjxz` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_peixinbaoming` (
  `id` int(10) unsigned NOT NULL,
  `peixunfangang` varchar(255) NOT NULL,
  `yuangongxingming` varchar(255) DEFAULT NULL,
  `bumen` varchar(255) NOT NULL,
  `laoshixingming` varchar(255) DEFAULT NULL,
  `peixunshijian` varchar(255) DEFAULT NULL,
  `peixunxuqiu` varchar(255) DEFAULT NULL,
  `shoukeshijian` varchar(255) DEFAULT NULL,
  `shoukeshuoming` varchar(255) DEFAULT NULL,
  `peixunyuefen` varchar(255) NOT NULL,
  `pxlx` varchar(255) NOT NULL,
  `tbsj` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_peixunfangang` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `neirong` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_recruitment` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `xingbie` varchar(255) NOT NULL,
  `lianling` varchar(255) NOT NULL,
  `jiguan` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `xuexiao` varchar(255) NOT NULL,
  `zhuanye` varchar(255) NOT NULL,
  `xueli` varchar(255) NOT NULL,
  `ganwei` varchar(255) NOT NULL,
  `xiangqing` varchar(255) NOT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_rlzy` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `rrrrr` varchar(255) NOT NULL,
  `xqbz` varchar(255) DEFAULT NULL,
  `fujain` varchar(255) DEFAULT NULL,
  `shouji` varchar(255) NOT NULL,
  `youxian` varchar(255) NOT NULL,
  `xingbie` varchar(255) NOT NULL,
  `yuanxi` varchar(255) NOT NULL,
  `baom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_scbbd` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `xqdd` varchar(255) DEFAULT NULL,
  `fujain` varchar(255) DEFAULT NULL,
  `shouji` varchar(255) NOT NULL,
  `youxian` varchar(255) NOT NULL,
  `xingbie` varchar(255) NOT NULL,
  `banji` varchar(255) NOT NULL,
  `ganwei` varchar(255) NOT NULL,
  `da2` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_shengchan` (
  `id` int(10) unsigned NOT NULL,
  `chengpin` varchar(255) NOT NULL,
  `bianhao` varchar(255) DEFAULT NULL,
  `jihua` varchar(255) NOT NULL,
  `shengchan` varchar(255) NOT NULL,
  `shuliang` varchar(255) NOT NULL,
  `shishi` varchar(255) NOT NULL,
  `shishiren` varchar(255) NOT NULL,
  `jihuabh` varchar(255) NOT NULL,
  `zhuangtai` varchar(255) NOT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `jihuazhid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_shoh` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `ddddd` varchar(255) NOT NULL,
  `xqbz` varchar(255) DEFAULT NULL,
  `fjian` varchar(255) DEFAULT NULL,
  `shouji` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `xingbie` varchar(255) NOT NULL,
  `zhiwei` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_tiang` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(500) NOT NULL,
  `gonghao` varchar(500) DEFAULT NULL,
  `bumeng` varchar(255) NOT NULL,
  `gangwei` varchar(255) NOT NULL,
  `leixing` varchar(500) NOT NULL,
  `zhuguanxingming` varchar(800) DEFAULT NULL,
  `biaoti` varchar(255) NOT NULL,
  `neirong` varchar(255) NOT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `xiaoyi` varchar(255) DEFAULT NULL,
  `date` varchar(255) NOT NULL,
  `year` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `tapw` varchar(255) DEFAULT NULL,
  `tadc` varchar(255) DEFAULT NULL,
  `tapy` varchar(255) DEFAULT NULL,
  `jianjin` int(10) DEFAULT NULL,
  `jasj` varchar(255) DEFAULT NULL,
  `tabh` varchar(255) DEFAULT NULL,
  `tel` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_tuiliaopingt` (
  `id` int(10) unsigned NOT NULL,
  `mingcheng` varchar(255) NOT NULL,
  `leixing` varchar(255) NOT NULL,
  `bianhao` varchar(255) NOT NULL,
  `songhuo` varchar(255) NOT NULL,
  `gongyings` varchar(255) NOT NULL,
  `miaoshu` varchar(255) NOT NULL,
  `tibaoren` varchar(255) NOT NULL,
  `shenp` varchar(255) DEFAULT NULL,
  `tupian` text,
  `shuoming` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `caigouren` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `jindu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_vijiaoshou` (
  `id` int(10) unsigned NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `keyanchengguo` varchar(255) NOT NULL,
  `lianxiwomen` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shortdesc` varchar(255) NOT NULL,
  `workroom` varchar(255) NOT NULL,
  `yanjiufangxiang` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_wjsg` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `bumen` varchar(255) NOT NULL,
  `sgnr` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `xiangqing` varchar(255) DEFAULT NULL,
  `year` varchar(255) NOT NULL,
  `mouth` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `riqi` varchar(255) DEFAULT NULL,
  `glybz` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_wjzlqd` (
  `id` int(10) unsigned NOT NULL,
  `mingc` varchar(255) NOT NULL,
  `wlbh` varchar(255) DEFAULT NULL,
  `wlgg` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `sgxz` varchar(255) NOT NULL,
  `gongyings` varchar(255) DEFAULT NULL,
  `wltp` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `shuliang` varchar(255) NOT NULL,
  `fj` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_workbaom` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `bumeng` varchar(255) NOT NULL,
  `dianhua` varchar(255) NOT NULL,
  `yidong` varchar(255) NOT NULL,
  `xiangxi` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `bmsx` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_wuliao` (
  `id` int(10) unsigned NOT NULL,
  `wuliaobianma` varchar(20) NOT NULL,
  `wuliaopingming` varchar(255) NOT NULL,
  `gongyingshang` varchar(255) NOT NULL,
  `lianxidianhua` varchar(10) NOT NULL,
  `youjian` varchar(255) NOT NULL,
  `wuliaojieshao` varchar(255) NOT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `beixuangongyingshang` varchar(255) DEFAULT NULL,
  `beixuangongyingshang2` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `wllb` varchar(255) NOT NULL,
  `wltp` text,
  `lxr` varchar(255) NOT NULL,
  `wlzt` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `cgzq` int(255) NOT NULL,
  `cgnyd` varchar(255) NOT NULL,
  `gongyings` varchar(255) DEFAULT NULL,
  `cgfzr` varchar(255) NOT NULL,
  `spdh` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_wuliu` (
  `id` int(10) unsigned NOT NULL,
  `hwmc` varchar(255) NOT NULL,
  `hwbh` varchar(255) DEFAULT NULL,
  `hwjjd` varchar(255) NOT NULL,
  `hwnr` varchar(255) NOT NULL,
  `shouhdd` varchar(255) NOT NULL,
  `shlxr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_wyh` (
  `id` int(10) unsigned NOT NULL,
  `xingming` varchar(255) NOT NULL,
  `bum` varchar(255) NOT NULL,
  `baomleix` varchar(255) NOT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `ganwei` varchar(255) DEFAULT NULL,
  `nianfen` varchar(255) NOT NULL,
  `yufen` varchar(255) NOT NULL,
  `riqi` varchar(255) NOT NULL,
  `cbkz` varchar(255) NOT NULL,
  `cbkzxg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_xiaoshougongzhang` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `bumen` varchar(255) NOT NULL,
  `gongzhangleixing` varchar(255) NOT NULL,
  `caigouhetong` varchar(10) NOT NULL,
  `gongyingshang` varchar(255) NOT NULL,
  `jine` varchar(255) NOT NULL,
  `hetongwuliao` varchar(500) NOT NULL,
  `qianziriqi` varchar(10) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `xiaoshouhetongbianhao` varchar(255) DEFAULT NULL,
  `leixingsy` varchar(255) NOT NULL,
  `guidang` varchar(255) NOT NULL,
  `xingbie` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_xinxidian` (
  `id` int(10) unsigned NOT NULL,
  `xinxidian` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `yue` varchar(255) NOT NULL,
  `tbsj` varchar(255) NOT NULL,
  `szbm` varchar(255) NOT NULL,
  `khqy` varchar(255) NOT NULL,
  `lxr` varchar(255) NOT NULL,
  `dianhua` varchar(255) NOT NULL,
  `ganwei` varchar(255) NOT NULL,
  `xxdzt` varchar(255) NOT NULL,
  `xxdbhq` varchar(255) NOT NULL,
  `khxz` varchar(255) NOT NULL,
  `sxkh` varchar(255) NOT NULL,
  `jlqk` varchar(255) DEFAULT NULL,
  `zt` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_xsbbd` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `sxmc` varchar(255) NOT NULL,
  `xqcc` varchar(255) DEFAULT NULL,
  `fjuj` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_xzbbd` (
  `id` int(10) unsigned NOT NULL,
  `mnae` varchar(255) NOT NULL,
  `sxmc` varchar(255) NOT NULL,
  `xdd` varchar(255) DEFAULT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  `sjhm` varchar(255) NOT NULL,
  `youx` varchar(255) NOT NULL,
  `riq` varchar(255) NOT NULL,
  `sqbn` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_yanfapingtai` (
  `id` int(10) unsigned NOT NULL,
  `dxmc` varchar(255) NOT NULL,
  `bianhao` varchar(255) NOT NULL,
  `suoslx` varchar(255) NOT NULL,
  `canshu` varchar(255) NOT NULL,
  `guanliren` varchar(255) NOT NULL,
  `zhuanan` varchar(255) NOT NULL,
  `zhuguan` varchar(255) NOT NULL,
  `zhuantai` varchar(255) NOT NULL,
  `tupyx` text,
  `fujian` varchar(255) DEFAULT NULL,
  `waibu` varchar(255) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `dxzhuant` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_yfbbd` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `sjmc` varchar(255) NOT NULL,
  `xqbz` varchar(255) DEFAULT NULL,
  `rujian` varchar(255) DEFAULT NULL,
  `shouji` varchar(255) NOT NULL,
  `yxiang` varchar(255) NOT NULL,
  `xingbie` varchar(255) NOT NULL,
  `banji` varchar(255) NOT NULL,
  `tib` varchar(255) NOT NULL,
  `jinji` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_ysqcx` (
  `id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_yuyue` (
  `id` int(10) unsigned NOT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `purchase` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `select` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mailbox` varchar(255) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_zazj` (
  `id` int(10) unsigned NOT NULL,
  `zamc` varchar(255) NOT NULL,
  `fzr` varchar(255) NOT NULL,
  `xiaoguo` varchar(255) NOT NULL,
  `xianqing` varchar(255) NOT NULL,
  `jiean` varchar(255) NOT NULL,
  `chengyuan` varchar(255) NOT NULL,
  `fjlz` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_zhuanan` (
  `id` int(10) unsigned NOT NULL,
  `zamc` varchar(255) NOT NULL,
  `tibaoren` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `jindu` varchar(255) NOT NULL,
  `jindu2` varchar(255) NOT NULL,
  `fujian2` varchar(255) DEFAULT NULL,
  `yuji` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_zhuanan2` (
  `id` int(10) unsigned NOT NULL,
  `tibaoren` varchar(255) NOT NULL,
  `bum` varchar(255) NOT NULL,
  `leixing` varchar(255) NOT NULL,
  `biaoti` varchar(255) NOT NULL,
  `xiangqing` varchar(255) NOT NULL,
  `fjian` varchar(255) DEFAULT NULL,
  `zycd` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_zjbbd` (
  `id` int(10) unsigned NOT NULL,
  `nn` varchar(255) NOT NULL,
  `rrrrr` varchar(255) NOT NULL,
  `xqdd` varchar(255) NOT NULL,
  `fjian` varchar(255) DEFAULT NULL,
  `banji` varchar(255) NOT NULL,
  `sjhm` varchar(255) NOT NULL,
  `youxiang` varchar(255) NOT NULL,
  `xingbie` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`p8_forms_item_zppt` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) DEFAULT NULL,
  `bumen` varchar(255) NOT NULL,
  `xueli` varchar(255) NOT NULL,
  `gongzuo` varchar(255) DEFAULT NULL,
  `gzdd` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `gwyq` varchar(255) DEFAULT NULL,
  `gwzz` varchar(255) NOT NULL,
  `fujian` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

REPLACE INTO `p8_forms_item` VALUES ('94','办事流程对照表','','16','1','admin','219.136.170.160','0','1300257178','1306894495','1306894495','1','0','9','admin','1301793974','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('116','办事流程对照表','','16','7','张国微','219.136.143.11','0','1300953782','1307420744','1307420744','1','0','9','admin','1301793974','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('123','办事流程对照表','','16','7','张国微','113.103.4.224','0','1301583011','0','1301583011','1','0','9','admin','1301793974','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('140','办事流程对照表','','16','7','张国微','61.140.172.30','0','1301794054','1307527129','1307527129','0','0','9','admin','1301794078','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('139','办事流程对照表','','16','1','admin','219.136.143.147','0','1301735330','1302325091','1302325091','0','0','9','admin','1301793974','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('214','常用电话','','27','1','admin','219.136.169.139','0','1306896387','0','1306896387','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('219','办事流程对照表','','16','1','admin','219.135.216.86','0','1307437808','1307527189','1307527189','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('220','办事流程对照表','','16','1','admin','219.135.216.86','0','1307437935','1307527212','1307527212','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('221','办事流程对照表','','16','1','admin','219.135.216.86','0','1307437973','1307527233','1307527233','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('222','办事流程对照表','','16','1','admin','219.135.216.86','0','1307438058','1307527252','1307527252','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('223','办事流程对照表','','16','1','admin','219.135.216.86','0','1307438104','1307527277','1307527277','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('224','办事流程对照表','','16','1','admin','219.135.216.86','0','1307438140','1307528322','1307528322','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('225','办事流程对照表','','16','1','admin','219.135.216.86','0','1307438267','1307527313','1307527313','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('226','办事流程对照表','','16','1','admin','219.135.216.86','0','1307438300','1307527328','1307527328','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('227','办事流程对照表','','16','1','admin','219.135.216.86','0','1307438605','1307527372','1307527372','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('228','办事流程对照表','','16','1','admin','219.135.216.86','0','1307438652','1307527389','1307527389','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('229','办事流程对照表','','16','1','admin','219.135.216.86','0','1307439335','1307527413','1307527413','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('230','办事流程对照表','','16','1','admin','219.135.216.86','0','1307439363','1307527451','1307527451','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('231','办事流程对照表','','16','1','admin','219.135.216.86','0','1307439499','1307527480','1307527480','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('232','办事流程对照表','','16','1','admin','219.135.216.86','0','1307439547','1307527497','1307527497','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('233','办事流程对照表','','16','1','admin','219.135.216.86','0','1307439635','1307527515','1307527515','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('234','办事流程对照表','','16','1','admin','219.135.216.86','0','1307439663','1307527600','1307527600','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('235','办事流程对照表','','16','1','admin','219.135.216.86','0','1307439707','1307527949','1307527949','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('236','流程查询平台','','16','1','admin','219.135.216.86','0','1307439764','1329102115','1329102115','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('237','办事流程对照表','','16','1','admin','219.135.216.86','0','1307439802','1307527648','1307527648','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('238','办事流程对照表','','16','1','admin','219.135.216.86','0','1307439914','1307527673','1307527673','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('239','办事流程对照表','','16','1','admin','219.135.216.86','0','1307439942','1307527693','1307527693','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('240','办事流程对照表','','16','1','admin','219.135.216.86','0','1307440219','1307527725','1307527725','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('241','办事流程对照表','','16','1','admin','219.135.216.86','0','1307440350','1307527757','1307527757','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('242','办事流程对照表','','16','1','admin','219.135.216.86','0','1307440406','1307527774','1307527774','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('243','办事流程对照表','','16','1','admin','219.135.216.86','0','1307440540','1307527790','1307527790','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('244','办事流程对照表','','16','1','admin','219.135.216.86','0','1307440564','1307527807','1307527807','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('245','办事流程对照表','','16','1','admin','219.135.216.86','0','1307440604','1307527834','1307527834','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('246','外部常用电话','','27','1','admin','219.135.216.86','0','1307441172','1307498710','1307498710','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('247','流程查询平台','','16','1','admin','219.135.216.86','0','1307443695','1329550522','1329550522','0','0','0','admin','1330613717','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('253','办事流程对照表','','16','1','admin','219.136.138.145','0','1307528811','0','1307528811','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('254','办事流程对照表','','16','1','admin','219.136.138.145','0','1307528915','0','1307528915','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('255','办事流程对照表','','16','1','admin','219.136.138.145','0','1307529294','0','1307529294','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('276','专案建议与问题收集','','47','1','admin','219.136.141.57','0','1309832790','0','1309832790','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('270','办事流程对照表','','16','7','张国微','202.102.194.78','0','1309166233','0','1309166233','0','0','9','admin','1309756089','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('282','流程查询平台','','16','7','张国微','113.109.12.241','0','1310189212','1329989996','1329989996','0','0','9','admin','1310210463','0','   同意。312');
REPLACE INTO `p8_forms_item` VALUES ('285','办事流程对照表','','16','94','张大全','61.144.102.51','0','1310268204','0','1310268204','0','0','99','admin','1330438916','0','');
REPLACE INTO `p8_forms_item` VALUES ('337','办事流程对照表','','16','1','admin','61.144.102.51','0','1310280436','0','1310280436','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('338','办事流程对照表','','16','1','admin','61.144.102.51','0','1310280436','0','1310280436','0','0','99','admin','1330743781','0','');
REPLACE INTO `p8_forms_item` VALUES ('339','流程查询平台','','16','1','admin','61.144.102.51','0','1310280436','1329129686','1329129686','0','0','99','admin','1330743925','0','');
REPLACE INTO `p8_forms_item` VALUES ('371','流程查询平台','','16','102','唐骏','219.136.136.46','0','1310360610','1329991288','1329991288','0','0','9','李开复','1329991266','0',' OK');
REPLACE INTO `p8_forms_item` VALUES ('377','外部常用电话','','27','7','张国微','113.77.40.54','0','1311315354','1315846528','1315846528','0','0','1','admin','1367074776','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('442','招聘平台','','78','1','admin','175.13.252.30','0','1468566022','0','1468566022','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('416','流程查询平台','','16','101','李开复','113.103.0.236','0','1329991222','0','1329991222','0','0','0','admin','1330613746','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('423','流程查询平台','','16','1','admin','61.144.102.110','0','1330606166','0','1330606166','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('432','学院常用电话','','27','0','','119.141.101.47','0','1398868416','0','1398868416','0','0','0','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('433','投诉建议','','4','0','','119.141.101.47','0','1398868488','0','1398868488','0','0','0','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('434','投诉建议','','4','0','','119.141.101.47','0','1398868539','0','1398868539','0','0','0','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('443','投诉建议','','4','1','admin','120.86.68.203','0','1505660602','0','1505660602','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('444','投诉建议','','4','1','admin','113.247.53.255','0','1505660821','0','1505660821','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('445','招聘平台','','78','0','','113.246.93.129','0','1507514597','0','1507514597','0','0','9','admin','1507514624','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('446','投诉建议','','4','1','admin','113.246.93.129','0','1507521949','0','1507521949','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('447','我要应聘','','77','1','admin','113.246.93.129','0','1507531753','0','1507531753','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('448','在线预约','','79','15','admin2','113.246.87.78','0','1520499319','0','1520499319','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item_banshi` VALUES ('94','物料采购价格审批','1','刘四龙','15989052365/020-2695896','先填表，在给张大军&lt;br /&gt;\r\n23342333\r\nwerwerewe\r\nsdfsdafsd\r\nsdfsfs\r\nfsdfdsfdfds','','http://www.php168.net/','C1005811','ArrayArrayArray','');
REPLACE INTO `p8_forms_item_banshi` VALUES ('116','费用报销流程','1','张小虎','020-4567894/13989568945','先提报在线审批---做好单据后提交给财务部，每月一次','','http://nw.php168.net/index.php','C1005815','2.2.jpg<!--#p8_attach#-->/core/forms/2011_06/07_10/d03c19b8d4211b00.jpg.cthumb.jpg<!--#p8_attach#-->/core/f2.2.jpg<!--#p8_attach#-->/core/forms/2011_06/07_10/d03c19b8d4211b00.jpg.cthumb.jpg<!--#p8_attach#-->/core/forms/2011_06/07_10/d03c19b8d4211b00.jpg.thumb.jpg','');
REPLACE INTO `p8_forms_item_banshi` VALUES ('123','申请办公文具流程','1','张小云','020-2356898','申请----填写表单---领取','','','C1005819','','');
REPLACE INTO `p8_forms_item_banshi` VALUES ('139','办理公司食堂饭卡','2','王杰','15987654321','找领导审批后直接到行政部领取','','www.php168.net','G123213213','','');
REPLACE INTO `p8_forms_item_banshi` VALUES ('140','申请企业公车','1','张小雨','020-25658945','122','11.jpg<!--#p8_attach#-->/core/forms/2011_04/04_21/471ff7edcbfa9367.jpg','http://php168.net','L001','Array<!--#p8_attach#-->/core/forms/2011_06/07_10/d03c19b8d4211b00.jpg.cthumb.jpg<!--#p8_attach#-->/core/forms/2011_06/07_10/d03c19b8d4211b00.jpg.thumb.jpg1244475966482206928.jpg<!--#p8_attach#-->/core/forms/2011_06/07_10/edabc94527652720.jpg.cthumb.jpg<!--#p8_attach#-->/core/forms/2011_06/07_10/edabc94527652720.jpg.thumb.jpg','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('219','企业流程生成','1','***','******/*******','','','http://','L001','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('220','公章使用申请','1','***','******/*******','','','http://','L002','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('221','合同归档与管理','1','***','******/*******','','','http://','L003','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('222','值班查询与新增','1','***','******/*******','','','http://','L004','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('223','值班确认与管理','1','***','******/*******','','','http://','L005','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('224','网络网络IT报修','1','***','******/*******','','','http://','L006','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('225','工作类报名流程','1','***','******/*******','','','http://','L007','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('226','娱乐活动类报名','1','***','******/*******','','','http://','L008','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('227','工资查询、签收、密码修改','1','***','*******/******','','','http://','L009','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('228','工资修改/工资Excel导入','1','***','*******/******','','','http://','L010','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('229','费用报销申请与审批','1','***','*******/******','','','http://','L011','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('230','供应商付款申请与审批','1','***','*******/******','','','http://','L012','','7');
REPLACE INTO `p8_forms_item_banshi` VALUES ('231','财务销售订单收款确认','1','***','*******/******','','','http://','L013','','12');
REPLACE INTO `p8_forms_item_banshi` VALUES ('232','企业物流发货流程','1','***','*******/******','','','http://','L014','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('233','质检参数录入与使用','1','***','*******/******','','','http://','L015','','11');
REPLACE INTO `p8_forms_item_banshi` VALUES ('234','仓库退料流程','1','***','*******/******','','','http://','L016','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('235','仓库收料发料流程','1','***','*******/******','','','http://','L017','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('236','BOM管理与新增流程','1','***','*******/******','234234342','','http://','L018','zlpt2.gif<!--#p8_attach#-->/core/forms/2012_02/13_11/e98c121dee5ed8b6.gif<!--#p8_attach#-->/core/forms/2012_02/13_11/e98c121dee5ed8b6.gif','4');
REPLACE INTO `p8_forms_item_banshi` VALUES ('237','研发资料管理与新增','1','***','*******/******','','','http://','L019','','4');
REPLACE INTO `p8_forms_item_banshi` VALUES ('238','生产计划新增与查询流','1','***','*******/******','','','http://','L020','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('239','生产数量每日登记','1','***','*******/******','','','http://','L021','','8');
REPLACE INTO `p8_forms_item_banshi` VALUES ('240','采购需求与执行查看','1','***','*******/******','','','http://','L022','','7');
REPLACE INTO `p8_forms_item_banshi` VALUES ('241','采购价格平台新增物料','1','***','*******/******','','','http://','L023','','7');
REPLACE INTO `p8_forms_item_banshi` VALUES ('242','供应商新增/修改流程','1','***','*******/******','','','http://','L024','','7');
REPLACE INTO `p8_forms_item_banshi` VALUES ('243','销售信息点提报与管理','1','***','*******/******','','','http://','L025','','5');
REPLACE INTO `p8_forms_item_banshi` VALUES ('244','销售客户管理提报与管理','1','***','*******/******','','','http://','L026','','5');
REPLACE INTO `p8_forms_item_banshi` VALUES ('245','销售成交订单提报与管理','1','***','*******/******','','','http://','L026','','5');
REPLACE INTO `p8_forms_item_banshi` VALUES ('247','售后平台使用教程','1','***','******/*******','','','http://','L027','dingcan.gif<!--#p8_attach#-->/core/forms/2012_02/18_15/43d6dbc414aca806.gif<!--#p8_attach#-->/core/forms/2012_02/18_15/43d6dbc414aca806.gifwenju.gif<!--#p8_attach#-->/core/forms/2012_02/18_15/5d3ce2e7d2781b87.gif<!--#p8_attach#-->/core/forms/2012_02/18_15/5d3ce2e7d2781b87.gif','6');
REPLACE INTO `p8_forms_item_banshi` VALUES ('253','在线办事结果查询与验证','1','***','*******/******','','','','L028','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('254','企业提案流程','1','***','*******/******','','','','L029','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('255','发放邮件和快递流程','1','***','*******/******','','','','L030','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('270','企业办事','1','222','222222','','','','L00111','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('282','领取公司饭卡','2','张三','1236454655','员工先填写一个饭卡表单（见附件），发到邮箱 4234343@163.com，然后拿着自己的身份证，去找行政部张兰。首次饭卡充值至少100元，另外饭卡需10元工本费。','饭卡申请表<!--#p8_attach#-->/core/forms/2012_02/23_17/d7a2174ed38a939a.doc','http://php168.net','L031','55555.jpg<!--#p8_attach#-->/core/forms/2012_02/23_17/fe9eccea5caebc10.jpg<!--#p8_attach#-->/core/forms/2012_02/23_17/fe9eccea5caebc10.jpg.thumb.jpg','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('285','办理社保流程','1','张大海','1212313254654','*********************************','','','L032','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('337','申请请假流程','1','张三','135222222','内容请你自己填写','Array','','L051','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('371','23432432','1','23423','23432','4234324343223wwerwe','','http://','234342','','3');
REPLACE INTO `p8_forms_item_banshi` VALUES ('338','客户申请代理流程','1','李四','136000000','内容请你自己填写','Array','','L052','','5');
REPLACE INTO `p8_forms_item_banshi` VALUES ('339','客户售后流程','1','王五','138000000','内容请你自己填写','Array','http://','L053','gdzc.gif<!--#p8_attach#-->/core/forms/2012_02/13_18/c0794b873d2fa79a.gif<!--#p8_attach#-->/core/forms/2012_02/13_18/c0794b873d2fa79a.gif','6');
REPLACE INTO `p8_forms_item_banshi` VALUES ('416','ertr','1','443535','34535343533','erterterert','','htt://php168.net','L888','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('423','234234','1','23423','234234','23432','','','23423','','2');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('40','2','马云','8','2','6','1','20','180','1','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('41','3','燕青','5','2','2','1','0','0','4','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('42','7','罗宾勋','15','4','12','2','20','100','1','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('43','11','廖华天','5','2','5','2','20','50','2','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('44','8','爱施德','4','2','4','1','10','20','3','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('45','15','罗军','7','2','6','2','23','89','2','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('46','12','王杰','2','3','2','1','12','35','3','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('47','5','海滨','20','2','20','1','50','160','1','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('63','3','代玲','0','3','0','1','12','0','1','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('64','5','王伟中','1','2','1','2','0','0','2','1200');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('10','1','某人','12','2','3','4','5','6','345','2','0','0','0','0','0','0','0','2','2','0','456345645','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('34','15','廖化天','12','5','4','2','1','1','1500','2','0','0','0','0','0','0','0','1','1','50','231321','2','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('35','8','梁建根','12','6','3','1','1','1','860','2','0','0','0','0','0','0','0','2','2','0','654645645','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('36','1','罗冰','12','1','1','0','0','1','50','1','0','0','0','0','0','0','0','2','1','0','456646','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('37','16','陈星','12','2','2','1','5','1','200','2','3','2','4','200','50','60','40','3','','10','56456456','2','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('38','9','王新宇','12','3','3','2','1','0','670','2','0','0','0','0','0','0','0','1','2','0','4564564','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('39','6','艾丝凡','12','3','3','2','1','5','700','1','4','5','4','4','50','50','50','2','1','500','5464564','2','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('65','4','张小亮','3','15','13','5','3','5','300','1','0','0','0','0','0','0','0','1','1','0','46564','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('66','6','戴笠','3','5','5','3','2','0','500','1','0','0','0','0','0','0','0','1','1','0','4454','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('67','10','毛小龙','3','10','5','1','4','2','500','1','0','0','0','0','0','0','0','1','1','0','的发生地','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('151','4','规范化','4','234','32','234','234','234','234','2','56','46','45','234','56','343','234','1','1','678','1231231','1','5678','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('154','3','fgh','3','45','45','0','0','0','0','2','0','10','10','200','200','100','400','1','1','456','sdfsdfsdf','2','560','');
REPLACE INTO `p8_forms_item_bom` VALUES ('88','48pF电容','02030405','48PCS','14','1','1000PCS','1','刘晓军','020-2356489','苹果规格书.rar<!--#p8_attach#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','123123','','2');
REPLACE INTO `p8_forms_item_bom` VALUES ('89','MTD2955V芯片','0203156','5PCS','60','1','100PCS','1','刘晓军','020-2356489','苹果规格书.rar<!--#p8_attach#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','21321321','','2');
REPLACE INTO `p8_forms_item_bom` VALUES ('90','BC849BLT1G芯片','02030506','5PCS','60','1','50PCS','1','刘晓军','020-2356489','','','','2');
REPLACE INTO `p8_forms_item_bom` VALUES ('91','33k电阻','02030509','100000PCS','0','1','10000PCS','2','张运来','020-2356489','苹果规格书.rar<!--#p8_attach#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','','','2');
REPLACE INTO `p8_forms_item_bom` VALUES ('92','电铃','020308','1PCS','50','3','100PCS','2',' 张运来','020-2356489','苹果规格书.rar<!--#p8_attach#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','','','2');
REPLACE INTO `p8_forms_item_bom` VALUES ('130','显示器','02050648','1台','20','1','10台','2','张昆明','020-2356489','','','','2');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('18','刘小军','3','更加OK','3213123','2132112312','2','2132321','2321','120','2321','3','','');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('19','张海','6','423423','234234','2342323432','2','32423','23423','500','2343','3','','');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('20','王海滨','4','234234','234234','','3','2476800','57600','324','34234','3','','朱国祥');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('21','黄文略','9','234234','23444564564556','','3','1785600','-28800','100','','3','','朱国祥');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('22','刘备雄','1','23432','23432432','','1','1872000','','200','','1','','张三丰');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('23','王立军','11','324234','234234','','2','1785600','-28800','300','','1','','朱国祥');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('24','朱立伦','5','23423','2342323','','1','2563200','-28800','10','','1','','刘利害');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('82','张正东','5','生产设备螺丝选型问题','详细内容看附件','','2','-28800','-28800','100','21323','3','','朱国祥');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('81','刘晓梅','7','如何改良产品准确性的提案','改良产品准确性的提案','','3','2563200','-28800','50','www.php168.net','3','','朱国祥');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('83','王小琴','3','如何加大销售部的代理商管理','何加大销售部的代理商管理，正文如下','','3','1300982400','1299772800','100','12312','3','张三，李四，王五','朱国祥');
REPLACE INTO `p8_forms_item_bybd1` VALUES ('372','345345','345435','1','1309795200','34543','2','34534534','','34534');
REPLACE INTO `p8_forms_item_bybd2` VALUES ('214','公安局','张小川','10','110','无','无','','广东省广州市龙口西','www.php168.net','');
REPLACE INTO `p8_forms_item_bybd2` VALUES ('246','公司行政部','***','13','********/*******','***********','***********','','','http://','');
REPLACE INTO `p8_forms_item_bybd2` VALUES ('377','aa','aa','2','aa','111111','','','','http://','');
REPLACE INTO `p8_forms_item_bybd2` VALUES ('432','3423r','dfasdfd','1','432543556546','4543543','43543@12.com','','','','');
REPLACE INTO `p8_forms_item_bybd3` VALUES ('419','345','34534535','1','1330358400','34534','');
REPLACE INTO `p8_forms_item_bybd3` VALUES ('274','dds','ddd','1','1318867200','','');
REPLACE INTO `p8_forms_item_bybd3` VALUES ('370','312312','123123','1','1310313600','','');
REPLACE INTO `p8_forms_item_bybd3` VALUES ('381','21321','213','1','1314806400','','');
REPLACE INTO `p8_forms_item_bybd3` VALUES ('385','1112','1122','1','1318348800','','');
REPLACE INTO `p8_forms_item_bybd4` VALUES ('368','23432','1','23423','23423');
REPLACE INTO `p8_forms_item_bybd4` VALUES ('383','姓名','2','报修事项 ','请填入报修事项  需维护的设备，将具体状况描述下 fgdf');
REPLACE INTO `p8_forms_item_bybd4` VALUES ('387','000000','3','00000','000000000000000');
REPLACE INTO `p8_forms_item_bybd4` VALUES ('417','王志东','2','电脑不能启动',' 不能启动，检查过电源了。');
REPLACE INTO `p8_forms_item_bybd4` VALUES ('418','郭台铭','1','认为切尔','人味儿额外人味儿');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('388','erwerq','','0','0','0','','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('389','','','0','0','0','1','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('390','','','0','0','0','','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('391','','','0','0','0','','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('392','李某人','','0','0','0','','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('393','张某人','','0','0','0','1','','当天我到了，刷卡机器有问题没能签到。');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('394','李某人','','0','0','0','','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('395','张某人','','0','0','0','1','','当天我到了，刷卡机器有问题没能签到。');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('396','李某人','','0','0','0','','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('397','张某人','','0','0','0','1','10','当天我到了，刷卡机器有问题没能签到。');
REPLACE INTO `p8_forms_item_caigougongzhang` VALUES ('165','678678768','3','67867876867','86786786','','67867867','867867867');
REPLACE INTO `p8_forms_item_caigougongzhang` VALUES ('157','S1001','1','电脑为何经常重启的原因','1、突然黑屏；2:、突然蓝屏；3:、突然重启','苹果规格书.rar<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','无','HP电脑');
REPLACE INTO `p8_forms_item_caigougongzhang` VALUES ('164','67867876','1','568675','568678676876','','576868678','6867');
REPLACE INTO `p8_forms_item_caigougongzhang` VALUES ('166','786786','1','678678','678678','','67867','678678');
REPLACE INTO `p8_forms_item_canpinjc` VALUES ('115','马达','N1002255','稳压电源、万用表','调节稳压电源0.75-1.6V，马达均能正常运转','','苹果规格书.rar<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','%e6%88%bf%e5%9c%b0%e4%ba%a71111.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/23_15/ac4814950239c868.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/23_15/ac4814950239c868.jpg.thumb.jpg','毛小孩','','','1','1');
REPLACE INTO `p8_forms_item_canpinjc` VALUES ('132','润滑油','02030405','温度计','12312312、士大夫说道','','','','23432','','','1','2');
REPLACE INTO `p8_forms_item_canpinjc` VALUES ('367','23324','2423432','23423','23423423423','','','','234234','','','2','2');
REPLACE INTO `p8_forms_item_cgbbd` VALUES ('427','324','23423423','423423423','','','','','');
REPLACE INTO `p8_forms_item_cgjhxq` VALUES ('215','HP电脑','0201006','2台','2','1307376000','X20110506001','S20111056001','销售部新增人员','马小龙','1','1','','');
REPLACE INTO `p8_forms_item_cgjhxq` VALUES ('363','23423','4234234','234234','1','1310313600','23423','234234','23423','23423423','2','1','23423424','');
REPLACE INTO `p8_forms_item_ckslfl` VALUES ('216','马达','1214454454','1','1','4','1306857600','南科大','N4565654','500个','420个','','','','','','','','','','','');
REPLACE INTO `p8_forms_item_ckslfl` VALUES ('252','螺丝钉0406','0203002','3','1','6','1307462400','','','','','','','','','','5月份库存总5200个','5月份共发料1000个','','','','5月底库存800个');
REPLACE INTO `p8_forms_item_ckslfl` VALUES ('365','312','2312','1','1','3','1310313600','12312','12321','312321','321312','312312','','','','','','','','','12321','');
REPLACE INTO `p8_forms_item_ckslfl` VALUES ('366','234234','234234','1','3','3','1310313600','234234','234234','234234','234234','32432432','','','','','','','','','23423','');
REPLACE INTO `p8_forms_item_dangweixingzhen` VALUES ('441','20101122057344588691.jpg<!--#p8_attach#-->/core/forms/2014_11/10_10/e6bbe167bee26e8b.jpg<!--#p8_attach#-->/core/forms/2014_11/10_11/216db2eace30c53f.jpg.thumb.jpg','科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果','1245c211m@qq.com','刘三才','教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介教师简介','行政楼A-505','代数， 有限群的表示论');
REPLACE INTO `p8_forms_item_dingcang` VALUES ('425','42','23423','1','234','234','2','342','23423','234','234');
REPLACE INTO `p8_forms_item_dlxstc` VALUES ('49','南方科技','刘生','23423','5666','4545','1','345345','','1','4','123456');
REPLACE INTO `p8_forms_item_gdzc` VALUES ('93','惠普电脑-N001','020106','2','张小军','5000','1236787200','1','1300204800','刘茂军','惠普电脑<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/240d3c9932a9eae6.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/240d3c9932a9eae6.jpg.thumb.jpg','苹果规格书.rar<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','213123','','');
REPLACE INTO `p8_forms_item_gdzc` VALUES ('129','奔驰汽车','G020108','4','廖华天','500000','924796800','1','1301587200','张小雨','%e6%88%bf%e5%9c%b0%e4%ba%a71111.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/23_15/ac4814950239c868.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/23_15/ac4814950239c868.jpg.thumb.jpg','苹果规格书.rar<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','','','');
REPLACE INTO `p8_forms_item_gdzc` VALUES ('150','打印机','G201526','5','周龙龙','5000','1238601600','1','1301846400','刘栋','11.jpg<!--#p8_r_attach1#-->/core/forms/2011_04/04_21/471ff7edcbfa9367.jpg<!--#p8_r_attach1#-->/core/forms/2011_04/04_21/471ff7edcbfa9367.jpg.thumb.jpg','','','','张小封');
REPLACE INTO `p8_forms_item_gongzi` VALUES ('172','林志颖','2','5','','1024','','0','php168.net','1','5588','1306857600','','','','');
REPLACE INTO `p8_forms_item_gongzi` VALUES ('173','高志','1','1','','370202198210104536','','0','654321','1','5588','1306857600','2102','1','1304265600','');
REPLACE INTO `p8_forms_item_gysfk` VALUES ('114','国微软件','N1005','2','1302624000','刘蓓蓓','先处理部分','','');
REPLACE INTO `p8_forms_item_gysfk` VALUES ('133','三一重工','020604','2','1303315200','刘小毛','已经支付','','');
REPLACE INTO `p8_forms_item_gysfk` VALUES ('134','协同集团','020604','2','1304006400','马银龙','暂无','','');
REPLACE INTO `p8_forms_item_gysfk` VALUES ('160','沃尔沃','3242342342','1','','43534','','','');
REPLACE INTO `p8_forms_item_gysfk` VALUES ('356','213132','12321','1','1310313600','21321','','','');
REPLACE INTO `p8_forms_item_gzqs` VALUES ('281','123','2','1','2','1','1','2345','3455','5','5');
REPLACE INTO `p8_forms_item_huodongbm` VALUES ('118','刘军马','3','020-26598956565','1245786545','2','希望加入到活动当中来','');
REPLACE INTO `p8_forms_item_huodongbm` VALUES ('266','sdfsdfsd','6','212312312','0','1','sdsdas','');
REPLACE INTO `p8_forms_item_huodongbm` VALUES ('273','234324','2','234234','0','1','234234','');
REPLACE INTO `p8_forms_item_huodongbm` VALUES ('343','2342343','2','23423432','0','1','234234342234234','');
REPLACE INTO `p8_forms_item_jdbbd` VALUES ('429','刘军','1','','','15989523698','dfsdfdsfs@163.com','电信02-1','2','学习部长');
REPLACE INTO `p8_forms_item_jiangshi` VALUES ('440','201122710224574742.gif<!--#p8_attach#-->/core/forms/2014_11/10_13/64e19f9df6d8fff1.gif<!--#p8_attach#-->/core/forms/2014_11/10_13/64e19f9df6d8fff1.gif.thumb.jpg','1.<a href=\"http://www.ams.org/mathscinet/search/publications.html?pg1=IID&amp;s1=660135\">Li, Shu Hai</a>; <a href=\"http://www.ams.org/mathscinet/search/publications.html?pg1=IID&amp;s1=790063\">Dai, Jin Jun</a>; <a href=\"http://www.ams.org/mathscinet/searc','jjdai@mail.ccnu.edu.cn','程亮','学习经历：<br />\r\n&nbsp;&nbsp; 2000~2005&nbsp;&nbsp;&nbsp; 武汉大学数学与统计学院&nbsp;&nbsp;基础数学专业&nbsp; &nbsp;获博士学位；<br />\r\n&nbsp;&nbsp; 1996~2000&nbsp;&nbsp;&nbsp; 中国石油大学(华东) 数学院&nbsp;&nbsp; 计算数学及应用软件专业&nbsp; 获学士学位。<br />\r\n工作经历：<br />\r\n&nbsp;&nbsp; 2005~今&nbsp;&nbsp;&','行政楼A-507','代数， 有限群的表示论');
REPLACE INTO `p8_forms_item_jiaoshou` VALUES ('437','刘三思','研究方向研究方向研究方向研究方向','科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果科研成果','1245commm@qq.com','行政楼A-508','11.jpg<!--#p8_attach#-->/core/forms/2015_01/10_12/96307c04c047f17c.jpg<!--#p8_attach#-->/core/forms/2015_01/10_12/96307c04c047f17c.jpg.thumb.jpg','2343');
REPLACE INTO `p8_forms_item_jiaoshou` VALUES ('438','董才林','计算机网络、云计算、智能计算与信息处理、统计应用','科研项目：<br />\r\n1.在研项目：合作研究：农产品质量安全监测系统，国家科技部，项目编号2011GB2D10002；<br />\r\n2.在研项目：合作研究：动态网络环境下的服务组合、重建与优化的研究，国家自然科学基金，合作，项目批准号：61070182；<br />\r\n3.合作研究：网络环境下的服务管理的基础理论研究，国家自然科学基金，合作，项目批准号：60873192；<br />\r\n4.合作研究：网络环境下自适应服务组合关键技术研究，国家自然科学基金，合作，项目批准号：60873193','cldong@mail.ccnu.edu.cn','行政楼A-507','11.jpg<!--#p8_attach#-->/core/forms/2015_01/10_12/96307c04c047f17c.jpg<!--#p8_attach#-->/core/forms/2015_01/10_12/96307c04c047f17c.jpg','董才林，1963年6月16日生于湖北省武汉市，教授。<br />\r\n华中科技大学管理学院博士毕业（管理科学与工程方向）。<br />\r\n中国现场统计研究会资源与环境统计分会常务理事。<br />\r\n电话：13307173822<br />\r\n电子邮件：<a href=\"mailto:cldong@mail.ccnu.edu.cn\">cldong@mail.ccnu.edu.cn</a>');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('1','昌启锋','2','http://nw.php168.net/index.php','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('2','小六子','1','http://nw.php168.net/index.php','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('9','昌启锋','5','6','30','456','1','3','2','5','20','20','200','5','6','2','0','0','3000','30','200','1000','1','300');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('14','晓燕','1','2','10','300','1','0','0','0','0','100','0','12','8','0','0','0','600','3','100','3000','1','1500');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('16','晓燕','1','1','12','100','1','1','1','0','0','20','0','10','8','2','0','0','500','0','0','1620','1','300');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('53','刘生生','3','3','56','560','1','0','0','2','48','100','10','3','2','0','0','0','300','0','0','200','','120');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('54','张龙梦','8','3','0','0','1','0','0','0','0','50','0','1','1','1','0','0','200','12','36','3500','1','1000');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('55','包云中','12','3','5','100','2','5','0','2','48','80','15','3','3','2','1','0','500','0','0','1860','2','150');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('56','张水仙','8','3','3','60','1','0','0','0','0','100','10','0','2','0','0','0','100','0','0','1500','1','200');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('59','何好懂','5','3','5','100','2','3','0','1','2','100','20','5','4','3','0','1','300','0','0','2300','1','1000');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('60','张治中','11','3','0','0','1','0','0','0','2','100','5','5','2','0','0','0','250','0','0','1500','3','150');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('61','张浩然','8','3','5','100','2','5','2','2','48','100','20','1','1','0','0','1','20','1','10','1200','2','500');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('62','王常贵','6','3','2','40','2','2','1','0','0','150','13','2','2','1','0','1','300','0','0','300','3','50');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('265','dd','1','1','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','0');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('378','要','1','1','0','0','1','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','0');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('384','撒地方的说法','1','1','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','0');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('400','123','1','1','0','0','2','31','31','31','31','0','9000','0','0','0','0','0','0','0','0','0','','0');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('405','请问','1','1','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','0');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('406','232323','1','2','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','0');
REPLACE INTO `p8_forms_item_kehu` VALUES ('442','','1','30','1489593600','23432','1','23434324232332','234','432','32432','1','1','1','2343232','2343','3242','23432','23432','234','23432','2','1','','93364-33379');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('206','刘海龙','1','5','1305820800','广州国微软件','刘海军','020-25698785','N23434234232','购买国微企业内网方案','2800','2','0','','','','');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('207','陈小龙','1','5','1305648000','江苏中孚石油','中均龙','1598528555','N8988988989','购买国微企业信息化产品','120000','1','0','','','','');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('213','d','1','1','1304179200','111','11','1111','11111','11111111','1111','1','0','','','','');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('359','2343242','1','3','1310313600','23432','234234','','234234','3243232','23423','1','0','','','','');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('401','CFbpKFrDKf','7','2','lWKflFBxKSsBubNkmyq','HFYEybYGjz','MLuRaDlBd','pMBsnUvZ','xrITahaaJUyfFMe','Thanks for writing such an easy-to-understand atrilce on this topic.','DtDZJbOBXyDmFSFBJjMhttp://www.facebook.com/profile.php?id=100003405859828','3','0','','','','');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('402','HhqCNJlna','9','5','XrdBbwoVkcTS','fORKurQSxplMsUB','ooiBpFIw','dbLSGRBVh','kIpTCvdAvuGQP','You got to push it-this eessntial info that is!','sbZTbjKeQhttp://www.facebook.com/profile.php?id=100003405882853','2','0','','','','');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('404','陈小龙','1373385600','1','陈小龙','陈小龙陈小龙陈小龙陈小龙陈小龙陈小龙','43232!@2143.com','14352565465','陈小龙','dasfdsafsadfsdfsadfsad','','2','123456','323532432432','1','4564rterwtew','dasfdsafsadfsdfsadfsaddasfdsafsadfsdfsadfsaddasfdsafsadfsdfsadfsad');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('405','23423','1374076800','2','234','23423','23423','2342','2342','','','3','12345678','23423','1','23432','23423432');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('406','23423','1397491200','1','23423','23423','23423','3423','23423','玩儿玩儿','','2','123456','234234','1','23423','玩儿玩儿');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('407','23423423','1403020800','','23423','23423432','23423','23423','23423','23423423342','','','2343','234234','1','23423','23423');
REPLACE INTO `p8_forms_item_kq` VALUES ('374','玩儿玩儿','3','2','1','1309190400','2342','23423423423','23423','','','','');
REPLACE INTO `p8_forms_item_kq` VALUES ('411','潘亮亮','3','1','9','1329840000','4','出去办事','','','','','');
REPLACE INTO `p8_forms_item_kq` VALUES ('415','‘快快捷键','4','1','2','1329235200','9','将怒旌盔','123456','','','','');
REPLACE INTO `p8_forms_item_mimaxiugai` VALUES ('279','王明','it','2','123','123','多打点');
REPLACE INTO `p8_forms_item_mimaxiugai` VALUES ('280','王明','it','1','123','123','多打点');
REPLACE INTO `p8_forms_item_mimaxiugai` VALUES ('401','fd','fdf','1','','123456','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('11','昌启峰','2011-1-25','1','会议安排','2','请查看具体详情','1','7','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('12','杨柳、张宇、刘三全、东三只、吴高','2011-1-26','16','网络割接','2','请查看具体详情','2','4','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('13','戴晓燕、张东西、百姓全、张雪莲、','2011-1-14','10','月度财务审核','2','请查看具体详情','1','2','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('95','罗正飞','2011-4-20','1','斯蒂芬里啦','1','请查看具体详情','1','1','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('96','张国微','2011-5-1','3','制定采购计划','2','请查看具体详情','2','3','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('97','张三丰','2011-3-20','8','仓库整改','1','请查看具体详情','1','3','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('98','张瑞','2011-4-1','6','统计售后问题','1','请查看具体详情','1','1','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('99','罗宾勋','2011-3-12','5','生产线调整','1','请查看具体详情','3','3','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('100','杨有才','2011-4-1','2','三季度销售总结','2','请查看具体详情','1','5','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('101','张小军','2011-4-1','1','季度总结大会','2','请查看具体详情','3','6','http://','1302537600','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('102','周俊','2011-3-2','4','G168项目','1','请查看具体详情','1','7','http://','1302624000','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('103','张星','2010-3-19','7','G108批次产品测试','2','请查看具体详情','1','3','http://','1297785600','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('104','王小峰','2010-3-12','13','配合售后部派车','1','主要处理常规事项','1','4','http://','1308931200','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('124','刘俊杰','9月4日14：00--5日19：00','4','打扫卫生，处理阶梯一室','1','打扫卫生','2','3','http://','1307548800','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('147','刘小军、朱晓中','9月4日14：00--5日19：00','1','企业安保值班','2','刘小军看监控室、朱晓中门岗值班','2','4','http://','1307289600','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('158','2342342423','5月06日17：30--23：00 ','15','会议布置','3','12121','2','2','http://www.php168.net','1308153600','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('167','34534534','345345','4','345435','3','345345345','345435','2','345345','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('346','34534534','345345','4','345435','3','345345345','345435','2','http://345345','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('348','刘小军、朱晓中','9月4日14：00--5日19：00','1','企业安保值班','2','刘小军看监控室、朱晓中门岗值班','2','4','http://','1307289600','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('349','刘俊杰','9月4日14：00--5日19：00','4','打扫卫生，处理阶梯一室','1','打扫卫生','2','3','http://','1307548800','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('350','王小峰','2010-3-12','13','配合售后部派车','1','主要处理常规事项','1','4','http://','1308931200','Z12021501','');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('7','30','杨柳','1','','8月18','充电','','','15','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('8','18','晓燕','1','杨柳','8月18、19晚上','撒地方四大发','7月20号','斯蒂芬撒打发','15','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('15','20','晓燕','1','','8月18、19','财务培训','','','14','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('48','28','刘海鸥','6','','8月18、19','执行力方面的培训需求','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('49','26','张东健','2','','3月18、19晚上均可','接受相关新员工的培训锻炼','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('50','28','','1','刘军军','','','3月份晚上均可，除周末','给学员处理相关事宜','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('51','14','马云龙','2','','3月18、19晚上','希望得到销售提高','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('52','10','','9','刘生生','','','3月20、22晚上','给学员上生产课程','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('57','20','','8','周智慧','','','3月20、22晚上均可','申请报名，希望可以得到支持','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('58','24','田丽丽','1','','3月份均可','接受公司安全培训应用','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('68','16','周海红','9','','3月份下班均可','主要是想提高生产设计这块的知识','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('69','12','刘婷婷','13','','3月18、19晚上均可','希望得到学习盘点物料的机会','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('70','22','吴长龙','3','','3月18、19','提案的技巧这块处理','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('71','27','包场填','8','','3月18、19晚上均可','学会国微内网操作','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('72','30','','4','马丽云','','','3月20、22晚上均可','给学员处理提案这块','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('73','27','','12','周智慧','','','3月20、22晚上均可','学习信息化','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('74','14','','2','东海滨','','','3月20、22晚上均可','处理','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('75','6','','6','周智慧','','','3月20、22晚上均可','123213','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('76','24','','2','王长远','','','3月20、22晚上均可','授课','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('77','18','','3','王伟','','','3月20、22晚上均可','授课','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('78','26','','1','朱孝天','','','3月20、22晚上均可','授课看看','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('79','22','','8','张照样','','','3月20、22晚上均可','授课看看','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('80','12','刘海洋','13','','3月18、19晚上均可','学习进步下','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('410','12','','2','','','','','','13','4','10');
REPLACE INTO `p8_forms_item_peixunfangang` VALUES ('433','fdsaf','dfsafdasfdsafdsfewrtewdgfdsfewr4erfdsfvcxzvsf','fdsaf','','');
REPLACE INTO `p8_forms_item_peixunfangang` VALUES ('434','fadsf','dsafdasfdwrewfdsafdsaf','dasfdsaf','','');
REPLACE INTO `p8_forms_item_peixunfangang` VALUES ('443','姓名','议内容议内容议内容议内容议内容','15014799789','男','test@test.com');
REPLACE INTO `p8_forms_item_peixunfangang` VALUES ('444','343242342342','23432','23423','男','23423');
REPLACE INTO `p8_forms_item_peixunfangang` VALUES ('446','23423','23423','234324','男','23432');
REPLACE INTO `p8_forms_item_recruitment` VALUES ('447','阿龙','1','24','湖南','15111098204','毛塘铺大学','软件','5','php','php','');
REPLACE INTO `p8_forms_item_shengchan` VALUES ('119','路由器','C002','2','2','5000PCS','1300291200','朱贵平','H20110328','1','请填入相关详细信息。','','小毛');
REPLACE INTO `p8_forms_item_shengchan` VALUES ('122','自行车','N2564','3','2','5000PCS','1301500800','毛小球','C200356894','2','3242323423234','','小毛');
REPLACE INTO `p8_forms_item_shengchan` VALUES ('360','3123','312','1','2','12321','1310313600','12321','12312312','2','12312','','123213');
REPLACE INTO `p8_forms_item_shengchan` VALUES ('361','123123','3123123','2','2','12312','1310400000','2312','12312','2','','新建 Microsoft Word 文档.doc<!--#p8_attach#-->/core/forms/2011_07/11_12/e7f2877f09f80c1b.doc','12312');
REPLACE INTO `p8_forms_item_shoh` VALUES ('428','张小云','1','钟文斌，副教授，四川财经职业学院基础部语文教研室主任。主研《应用文写作》和《商务秘书学》，现主要讲授《应用文写作》《公共关系学》和《商务秘书学》。\r\n主要科研成果：\r\n1．2005年参加高等教育出版社“中等职业学校文化基础课”《语文》第一册第六单元的编写。\r\n2．2005年至2006年任五年制高职语文系列教材副主编，第一分册教材、教学参考书、多媒体课件文字脚本、同步练习册主编；同时，参编第二册第五单元教材、教学参考书、多媒体课件文字脚本、同步练习册；第三册第六单元教学参考书、第六册《财经应用文》诉讼文书及','','15989523698/020-8726356','ewrereewr@163.com','2','教授');
REPLACE INTO `p8_forms_item_tiang` VALUES ('3','23423','234','1','1','1','23423','23423','23423','23422342323423','234233','','','','','','','0','','','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('4','肖同事','','1','1','1','肖先生','提供升级了吗','系统软件提供升级了吗','Dormy.png<!--#p8_attach#-->/core/forms/2011_02/14_18/a74eee8657b79b50.png.cthumb.jpg<!--#p8_attach#-->/core/forms/2011_02/14_18/a74eee8657b79b50.png.thumb.jpg','提供升级了吗','','','','','','','0','','','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('5','王五','','2','2','2','张三','电脑中招了','电脑中招了，电脑中招了','Dormy.png<!--#p8_attach#-->/core/forms/2011_02/14_18/a74eee8657b79b50.png.cthumb.jpg<!--#p8_attach#-->/core/forms/2011_02/14_18/a74eee8657b79b50.png.thumb.jpg','电脑中招','','','','','','','0','','','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('105','王小峰','','3','2','1','罗欣','G108项目的开发流程优化','由原来的垂直开发流程可以优化为树形开发流程，多个开发步骤同时进行。','','可以缩短项目的研发时间，节省项目费用。','1300636800','1','5','处理中','4','','0','1305734400','T1125191223','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('26','张小鹏','','1','2','3','刘军','采购订单编号优化方案','现在的编号不是很好记忆和收集。&lt;br /&gt;\r\n&lt;br /&gt;\r\n建议改为公司缩写+年+月+日+随机码','案例文档案例文档','大幅提高了合同订单的阅读性。','1294156800','1','4','处理中','1','','0','','T1125191256','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('27','黄文略','','2','1','1','骏龙','代理商整理问题','现在的代理商的资料查找、统计、资料变化没有完整的整理或平台，能否信息化','1221','资料标准化','1296576000','1','5','处理中','2','','200','1305734400','T1125191225','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('28','刘云','','4','2','1','王海滨','研发物料申请流程优化','现在的研发物流申请流程过于复杂，可以优化下','121212','可以大幅节省时间','1298908800','1','5','处理中','3','','0','1305734400','T1125191240','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('29','张宇','','6','1','3','张宇','网线选型与购买方案','大量同事反应网络 不通，经过排查为网线质量问题。','','','1297180800','1','5','处理中','2','werwe','0','1305734400','T1105261235','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('30','刘龙中','','2','2','1','黄文略','销售部设立用户协调机制','现在有争议的客户资源，都是双方私下协商，希望公司出一个指导思想','','','1294070400','1','5','刘海涛','4','','0','1305734400','T1105251235','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('31','马丽丽','','2','2','3','刘婷玉','关于公司垃圾分类与实施','垃圾太多，最近实施分类，并联络好社会相应的人员，将公司的分类垃圾处理。','','','1299513600','1','5','处理中','2','','50','1305734400','T1125191260','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('32','刘备雄','','1','1','3','骏龙','企业信息化实施与方案','企业现在迫切需要上线信息化需求。','','','1299600000','1','5','处理中','2','','1000','1305734400','T1125191246','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('33','张宇','','1','1','3','骏龙','企业形象窗口公司网站的改良','企业形象窗口公司网站的改良，直接关系到公司的业务与宣传。','','','1299600000','1','5','处理中','2','','200','1305734400','T1125191245','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('106','张三丰','','8','1','2','马飞','成品存储仓库整改方案','通过对成品存储仓库的整改可以减少成品存储时不必要的损坏','','通过对成品存储仓库的整改可以减少成品存储时不必要的损坏','1300636800','1','5','玩儿，我认为，玩儿','3','士大夫士大夫','100','1305734400','T1125191240','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('107','杨柳','','3','2','1','周俊','MSC的管理平台不稳定问题','MSC的管理平台不稳定问题，导致不能进行日常的管理。','','','1300550400','1','5','士大夫，让让她，儿童','3','的风格大方发到发到','100','1305734400','T1125191239','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('108','晓燕','','2','2','2','张菲','公司营业厅装修方案','包括总体预算、设计方案、装修材料、施工队伍','','','1300896000','1','5','为二位，玩儿','2','为二位玩儿玩儿王二人','4000','1305734400','T1125191237','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('169','45455','454','3','1','3','454','45645','456464','','45465','1305648000','','','','','','0','','','','');
REPLACE INTO `p8_forms_item_tuiliaopingt` VALUES ('120','马达','1','C102125689','N12456898','华伦天奴','抽检不符规格','刘俊杰','张四通','','暂时无','','刘小毛','1301500800','2');
REPLACE INTO `p8_forms_item_tuiliaopingt` VALUES ('121','40欧热敏电阻','2','N20258964','N56023548','恒基电子','数量不足','刘俊杰','张四通','','暂时无','','刘小毛','1301500800','1');
REPLACE INTO `p8_forms_item_tuiliaopingt` VALUES ('131','显示器','1','02030509','S020315','索尼电子','有压坏','王杰出','刘海滨','','1212','','张冬储','1303488000','1');
REPLACE INTO `p8_forms_item_tuiliaopingt` VALUES ('364','2324332','2','34234','23432','423432','2342342','234234','324234','','','','234324','1311004800','2');
REPLACE INTO `p8_forms_item_vijiaoshou` VALUES ('439','20101139550924446.jpg<!--#p8_attach#-->/core/forms/2014_11/10_13/537410ade772e9ae.jpg<!--#p8_attach#-->/core/forms/2014_11/10_13/537410ade772e9ae.jpg.thumb.jpg','<p>\r\n	学术交流情况：<br />\r\n	2003.9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;：&nbsp;参加第1届中德群论国际会议<br />\r\n	2006.9-2007.1:&nbsp;北京大学数学科学学院访问学者<br />\r\n	2008.2-2008.6:&nbsp;上海外国语大学出国培训中心外语培训<br />\r\n	2008.9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;参加第4届中','chenga9762002@aliyun.com','陈老师','教育、工作经历:&nbsp;<br />\r\n1996.9-2000.6:&nbsp;就读于华中师范大学数学系数学教育专业<br />\r\n2000.9-2005.6:&nbsp;就读于武汉大学数学统计学院,&nbsp;2005.6取得理学博士学位<br />\r\n2005.7-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;在华中师范大学数学与统计学学院工作','六号教学楼 405','代数， 有限群的表示论 ');
REPLACE INTO `p8_forms_item_wjsg` VALUES ('420','23423','2','23423424234','23432424','23423','2','2','1330531200','','','');
REPLACE INTO `p8_forms_item_wjsg` VALUES ('421','345','2','34534','345','','1','1','1330531200','','','');
REPLACE INTO `p8_forms_item_wjsg` VALUES ('422','34534','1','34534','345','','1','2','1330531200','','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('272','耳嗡嗡 ','1','23423','2342342','23424234','23423','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('340','234234234','2','2342342','234232','23423423234','','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('341','3333333','3','333','333','333333','33','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('342','23423','4','2342343','234234','23423423234','234324','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('352','23232423','3','23432','2343242','23423423','','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('373','2343242','2','23423424','234234','23423423432432','','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('375','23424','3','23423','23423','23432','','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('413','chang','2','234234','234234','23423423423432','234234','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('414','324234','2','','23432','2343243243','3242','','');
REPLACE INTO `p8_forms_item_wuliu` VALUES ('111','通讯手机/设备','C20110319','2','手机1000条，通讯设备50个','广州天河区龙溪口建筑交易中心大厦201','刘大鹏');
REPLACE INTO `p8_forms_item_wuliu` VALUES ('112','拖拉机','N2564895','1','拖拉机10台','广州南方大厦208','中军');
REPLACE INTO `p8_forms_item_wyh` VALUES ('250','刘海龙','6','1','经过与采购商安富利的商谈，将IC5806价格减低至40元/pcs，较最近采购价格低5毛/Pcs。\r\n\r\n\r\n','','采购部工程师','2','6','1307462400','IC5806采购价格降低5毛/PCS','预计1年后，可以将节约成本3万美金。\r\n\r\n\r\n');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('168','1213213121','2','5','4546554','1216545465','500','4654456454','1305129600','','','1','2','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('144','郭小薇','4','100','PS20110406','湖南三一重工集团','20000','国微内网方案1套，配套培训','1301760000','合同word文本.rar<!--#p8_attach#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','','1','1','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('145','朱风伟','4','100','PA20110406','南京卓越科技有限公司','0','南京地区国微代理权','1302624000','','','4','2','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('146','李桂军 ','6','100','PV20110406','云南大利集团','0','新增云南大利集团为公司供应商。','1301760000','','','3','1','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('271','味儿','2','100','34232','2342342','423423423','423423423423342','1306512000','','234','1','1','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('345','23423','6','100','3423423','士大夫','23423','23423423423','315849600','','','2','1','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('369','2342342','3','5','23424','23423','23423','23423423','1310313600','','','2','1','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('404','随碟附送的风','3','100','风set热','啥地方','1111','11111','1323705600','','','1','1','');
REPLACE INTO `p8_forms_item_xinxidian` VALUES ('208','周小龙','1','1','1305820800','1','广州国微软件科技有限公司','张三丰','020-38907975','刘海龙','2','1','1','1','','');
REPLACE INTO `p8_forms_item_xinxidian` VALUES ('209','周小龙','1','5','1305820800','2','广州国微软件科技有限公司','刘四龙','020-29865986/1569865986','经理','2','1','2','1','','');
REPLACE INTO `p8_forms_item_xinxidian` VALUES ('351','345345','2','3','1310227200','2','34534523','23452345','34543454','32453454','3','1','1','1','345345345345345435','1');
REPLACE INTO `p8_forms_item_xinxidian` VALUES ('357','2343242','2','2','1310313600','1','23432','23423','23432','23423','1','1','1','1','23423','1');
REPLACE INTO `p8_forms_item_yanfapingtai` VALUES ('113','40V变压器','C123456','2','40V，安全性高，10A电流','张小云','1','张骏龙','1','5.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/240d3c9932a9eae6.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/240d3c9932a9eae6.jpg.thumb.jpg','','','','1');
REPLACE INTO `p8_forms_item_yuyue` VALUES ('448','4','23423432','1','234232','1','23423423','23423','2342343');
REPLACE INTO `p8_forms_item_zhuanan2` VALUES ('276','12312','2','1','12312321321232','1231232131','','');
REPLACE INTO `p8_forms_item_zppt` VALUES ('442','信息系统管理员','5','运行维护部','本科','3','长沙','1','23岁以上','1.专科及以上学历，男性，计算机类相关专业，有软件开发工作经验者优先\r\n2.能熟练使用一种或两种开发语言，参与过大型项目的软件实施者优先；\r\n3.熟悉软件开发流程，能配合软件供应商进行各信息系统项目的全程跟踪；\r\n4.有较好的沟通能力、协调能力及执行力，责任心强，有良好的团队协作精神。','1. 负责根据公司信息化规划，配合完成信息化系统实施，包括系统调研与规划、系统实施、系统后期维护等，保障信息系统的正常运行，并对系统中出现的问题及时予以处理；\r\n2. 负责制定和修订系统运行的管理制度，完善各信息系统的制度文件；\r\n3. 负责完成领导安排的临时工作。','');
REPLACE INTO `p8_forms_item_zppt` VALUES ('445','php','2','网络运营部','大专以上','1','长沙','1','20','工作认真负责','工作认真负责','');
REPLACE INTO `p8_forms_model` VALUES ('77','recruitment','我要应聘','1','','0','1','245','post_yingpin','list_yingpin','view_yingpin','a:0:{}');
REPLACE INTO `p8_forms_model` VALUES ('78','zppt','招聘平台','1','','0','2','250','post_2017','list_supplier2017','view_print_2017','a:2:{s:7:\"captcha\";s:1:\"1\";s:8:\"viewself\";s:1:\"1\";}');
REPLACE INTO `p8_forms_model` VALUES ('16','banshi','流程查询平台','1','9','0','45','249','','list_supplier3c','view_print','a:1:{s:6:\"status\";a:2:{i:1;s:6:\"已处理\";i:2;s:6:\"处理中\";}}');
REPLACE INTO `p8_forms_model` VALUES ('4','peixunfangang','投诉建议','1','','0','5','253','post_tousujianyi','list_supplier3','view_print2','a:2:{s:6:\"status\";a:1:{i:1;s:9:\"已处理\";}s:8:\"viewself\";s:1:\"1\";}');
REPLACE INTO `p8_forms_model` VALUES ('27','bybd2','常用电话','1','','0','4','245','','list_supplier3c','view_print','a:1:{s:7:\"captcha\";s:1:\"1\";}');
REPLACE INTO `p8_forms_model` VALUES ('47','zhuanan2','专案建议与问题收集','1','','0','1','0','','list_status2','view_print','a:1:{s:8:\"viewself\";s:1:\"1\";}');
REPLACE INTO `p8_forms_model` VALUES ('69','bybd6','查询平台','1','','0','0','240','','list_luqu3','view_luqujieguo','a:0:{}');
REPLACE INTO `p8_forms_model` VALUES ('79','yuyue','在线预约','1','','0','1','255','post_yuyue','list_supplier2018','view_yueyue','a:0:{}');
REPLACE INTO `p8_forms_model_field` VALUES ('83','dails','0','dlsxm','代理商名称','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','70','','','','','请填入代理商企业名称');
REPLACE INTO `p8_forms_model_field` VALUES ('121','dlsdd','0','cwqrdz','财务确认到账','varchar','14003-1','0','1','0','0','255','0','1','0','','a:3:{i:1;s:8:\"尚未到账\";i:2;s:8:\"已经到账\";i:3;s:8:\"其他状态\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','0','','','','','请确认代理商提交的款项状态是否已经到账');
REPLACE INTO `p8_forms_model_field` VALUES ('195','banshi','0','bianhao','流程编号','varchar','','1','1','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','style=\"width:85px;border:1px soild #ff0000\"','98','','','','','请填入此流程的编号，没有则不填，一般是L***,如L001');
REPLACE INTO `p8_forms_model_field` VALUES ('185','banshi','0','bslb','事项类别','varchar','','1','0','0','1','255','0','1','0','','a:4:{i:1;s:10:\"工作业务类\";i:2;s:10:\"常见生活类\";i:3;s:10:\"文艺体育类\";i:4;s:4:\"其他\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','96','','','','','请选择该办事类别');
REPLACE INTO `p8_forms_model_field` VALUES ('192','banshi','0','czsm','流程操作说明','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:0:{}','textarea','cols=\"70\" rows=\"10\"','82','','','','','请填入该办事的具体流程说明');
REPLACE INTO `p8_forms_model_field` VALUES ('193','banshi','0','fujian','附件资料','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','uploader','','80','','','','','该办事如有附件说明，请上传');
REPLACE INTO `p8_forms_model_field` VALUES ('194','banshi','0','lianj','链接地址','varchar','','0','0','0','0','255','0','1','0','','a:1:{s:6:\"target\";s:6:\"_blank\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','link','size=\"70\"','78','','','','','选填，如有相关网址详细说明，请填写');
REPLACE INTO `p8_forms_model_field` VALUES ('187','banshi','0','lxr','联络人','varchar','','1','0','0','1','255','0','1','0','','a:0:{}','a:0:{}','text','','92','','','','','请填入该事项的联系人或各部门相应岗位');
REPLACE INTO `p8_forms_model_field` VALUES ('184','banshi','0','name','事项名称','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','100','','','','#111','请输入办事事项名称');
REPLACE INTO `p8_forms_model_field` VALUES ('538','banshi','0','sybumen','使用部门','varchar','','1','1','0','1','255','0','1','0','','a:6:{i:1;s:8:\"公共部门\";i:3;s:8:\"本科生部\";i:4;s:8:\"研究生部\";i:5;s:8:\"博士生部\";i:6;s:8:\"学院老师\";i:7;s:8:\"其他部门\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','95','','','','','请选择该流程可能会使用的部门');
REPLACE INTO `p8_forms_model_field` VALUES ('188','banshi','0','tel','电话/手机','varchar','','1','0','0','1','255','0','1','0','','a:0:{}','a:0:{}','text','','90','','','','','请填入该联系人电话');
REPLACE INTO `p8_forms_model_field` VALUES ('25','peixunfangang','0','name','姓名','varchar','','1','1','0','1','255','0','1','0','','a:1:{s:6:\"target\";s:5:\"_self\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','60','','','','','请填入您的姓名');
REPLACE INTO `p8_forms_model_field` VALUES ('861','yuyue','0','city','所在城市','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('702','peixunfangang','0','tel','移动电话','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','58','','','','','请填写您的联系方式，方便回馈');
REPLACE INTO `p8_forms_model_field` VALUES ('27','peixunfangang','0','neirong','详细内容','varchar','','0','0','0','1','255','0','1','0','','a:1:{s:6:\"target\";s:5:\"_self\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"70\" rows=\"10\"','10','','','','','填入详细内容');
REPLACE INTO `p8_forms_model_field` VALUES ('862','yuyue','0','purchase','采购性质','varchar','','0','0','0','1','255','0','1','0','1','a:2:{i:1;s:6:\"个人\";i:2;s:6:\"公司\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','radio','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('836','zppt','0','name','招聘职位','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','请填写您的姓名');
REPLACE INTO `p8_forms_model_field` VALUES ('837','zppt','0','number','招聘人数','varchar','','1','1','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','人','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('838','zppt','0','bumen','招聘部门','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('839','zppt','0','xueli','学历要求','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('840','zppt','0','gongzuo','工作经验','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','年','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('841','zppt','0','gzdd','工作地点','varchar','','1','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('842','zppt','0','sex','性别','varchar','','0','0','0','1','255','0','1','0','','a:3:{i:1;s:2:\"男\";i:2;s:2:\"女\";i:3;s:4:\"不限\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('843','zppt','0','age','年龄要求','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','size=\"38\"','0','','','','','请填写相关事项的名称');
REPLACE INTO `p8_forms_model_field` VALUES ('844','zppt','0','gwyq','岗位要求','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"70\" rows=\"10\"','0','','','','','请填写相关详情');
REPLACE INTO `p8_forms_model_field` VALUES ('845','zppt','0','gwzz','岗位职责','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"70\" rows=\"10\"','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('846','zppt','0','fujian','附件','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','uploader','','0','','','','','如有附件请上传');
REPLACE INTO `p8_forms_model_field` VALUES ('847','recruitment','0','name','姓名','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','35','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('848','recruitment','0','xingbie','性别','varchar','','0','0','0','1','255','0','1','0','1','a:2:{i:1;s:3:\"男\";i:2;s:3:\"女\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','radio','','33','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('849','recruitment','0','lianling','年龄','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','31','','','','','岁');
REPLACE INTO `p8_forms_model_field` VALUES ('850','recruitment','0','jiguan','籍贯','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','28','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('851','recruitment','0','tel','联系电话','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','26','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('852','recruitment','0','xuexiao','毕业学校','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','24','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('853','recruitment','0','zhuanye','所学专业','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','21','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('854','recruitment','0','xueli','学历','varchar','','0','0','0','1','255','0','1','0','','a:5:{i:1;s:4:\"博士\";i:2;s:4:\"硕士\";i:3;s:4:\"本科\";i:4;s:4:\"专科\";i:5;s:4:\"其他\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','18','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('855','recruitment','0','ganwei','应聘岗位','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','16','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('856','recruitment','0','xiangqing','详细说明','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"100\" rows=\"20\"','12','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('857','recruitment','0','fujian','附件文档','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','uploader','','10','','','','','如有附件文档可上传');
REPLACE INTO `p8_forms_model_field` VALUES ('334','banshi','0','tupian','图片说明','text','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','multi_uploader','size=\"2\"','81','','','','','如有图片说明可上传');
REPLACE INTO `p8_forms_model_field` VALUES ('438','bybd2','0','mingcheng','单位名称','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','请填入联系单位名称');
REPLACE INTO `p8_forms_model_field` VALUES ('439','bybd2','0','lxr','联系人','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','请填入联系人名称');
REPLACE INTO `p8_forms_model_field` VALUES ('440','bybd2','0','leixing','单位类型','varchar','','1','1','0','1','255','0','1','0','','a:13:{i:13;s:12:\"企业内部电话\";i:1;s:8:\"快递公司\";i:2;s:8:\"送水公司\";i:3;s:8:\"送餐店面\";i:4;s:8:\"运输公司\";i:5;s:8:\"搬家公司\";i:6;s:8:\"招聘机构\";i:7;s:8:\"附近银行\";i:8;s:6:\"小卖部\";i:9;s:8:\"旅游公司\";i:10;s:8:\"政府电话\";i:11;s:8:\"医院急救\";i:12;s:4:\"其他\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','0','','','','','请选择该单位所属类型');
REPLACE INTO `p8_forms_model_field` VALUES ('441','bybd2','0','tel','电话/手机','varchar','','1','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','请输入联系人电话与手机号码');
REPLACE INTO `p8_forms_model_field` VALUES ('442','bybd2','0','fax','传真号码','varchar','','1','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','请输入联系人传真号码');
REPLACE INTO `p8_forms_model_field` VALUES ('443','bybd2','0','email','邮箱','varchar','','1','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','请输入联系人邮箱');
REPLACE INTO `p8_forms_model_field` VALUES ('444','bybd2','0','QQ','QQ/MSN','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','请输入联系人QQ/MSN号码');
REPLACE INTO `p8_forms_model_field` VALUES ('445','bybd2','0','dizhi','具体地址','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','size=\"38\"','0','','','','','请输入联系单位具体地址');
REPLACE INTO `p8_forms_model_field` VALUES ('446','bybd2','0','wangzhi','网址','varchar','','0','0','0','0','255','0','1','0','','a:1:{s:6:\"target\";s:6:\"_blank\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','link','','0','','','','','请输入联系单位的具体网址');
REPLACE INTO `p8_forms_model_field` VALUES ('447','bybd2','0','beizhu','备注说明','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"70\" rows=\"6\"','0','','','','','如还有相关备注，请输入');
REPLACE INTO `p8_forms_model_field` VALUES ('860','yuyue','0','province','所在省份','varchar','','0','0','0','0','255','0','1','0','','a:34:{i:1;s:6:\"北京\";i:2;s:6:\"上海\";i:3;s:6:\"天津\";i:4;s:6:\"重庆\";i:5;s:6:\"四川\";i:6;s:6:\"贵州\";i:7;s:6:\"云南\";i:8;s:6:\"西藏\";i:9;s:6:\"河南\";i:10;s:6:\"湖北\";i:11;s:6:\"湖南\";i:12;s:6:\"广东\";i:13;s:6:\"广西\";i:14;s:6:\"陕西\";i:15;s:6:\"甘肃\";i:16;s:6:\"青海\";i:17;s:6:\"宁夏\";i:18;s:6:\"新疆\";i:19;s:6:\"河北\";i:20;s:6:\"山西\";i:21;s:9:\"内蒙古\";i:22;s:6:\"江苏\";i:23;s:6:\"浙江\";i:24;s:6:\"安徽\";i:25;s:6:\"福建\";i:26;s:6:\"江西\";i:27;s:6:\"山东\";i:28;s:6:\"辽宁\";i:29;s:6:\"吉林\";i:30;s:9:\"黑龙江\";i:31;s:6:\"海南\";i:32;s:6:\"台湾\";i:33;s:6:\"香港\";i:34;s:6:\"澳门\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','class=\"set\"','100','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('580','zhuanan2','0','tibaoren','提报人','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','30','','','','','请填写提报人姓名');
REPLACE INTO `p8_forms_model_field` VALUES ('581','zhuanan2','0','bum','部门','varchar','','1','1','0','1','255','0','1','0','','a:17:{i:1;s:10:\"公司领导层\";i:2;s:6:\"行政部\";i:3;s:6:\"研发部\";i:4;s:6:\"销售部\";i:5;s:6:\"售后部\";i:6;s:6:\"采购部\";i:7;s:6:\"生产部\";i:8;s:6:\"计调部\";i:9;s:6:\"质检部\";i:10;s:6:\"仓管部\";i:11;s:6:\"财务部\";i:12;s:10:\"人力资源部\";i:13;s:6:\"物流部\";i:14;s:6:\"后勤部\";i:15;s:6:\"公关部\";i:16;s:6:\"网络部\";i:17;s:8:\"其他部门\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','28','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('582','zhuanan2','0','leixing','类型','varchar','','1','1','0','1','255','0','1','0','','a:3:{i:1;s:8:\"专案建议\";i:2;s:8:\"专案问题\";i:3;s:4:\"其他\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','26','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('583','zhuanan2','0','biaoti','标题','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','size=\"50\"','22','','','','','请输入内容的标题');
REPLACE INTO `p8_forms_model_field` VALUES ('584','zhuanan2','0','xiangqing','内容详情','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"90\" rows=\"14\"','20','','','','','请填写专案建议或问题详情');
REPLACE INTO `p8_forms_model_field` VALUES ('585','zhuanan2','0','fjian','附件资料','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','uploader','','0','','','','','如有附件资料，可上传。');
REPLACE INTO `p8_forms_model_field` VALUES ('593','zhuanan2','0','zycd','重要程度','varchar','','1','1','0','1','255','0','1','0','','a:4:{i:1;s:4:\"正常\";i:2;s:4:\"重要\";i:3;s:6:\"不重要\";i:4;s:4:\"其他\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','24','','','','','请选择问题和建议您觉得的重要与紧急程度');
REPLACE INTO `p8_forms_model_field` VALUES ('787','bybd6','0','baofei','录取状态','varchar','','1','0','0','0','255','0','1','0','','a:4:{i:5;s:6:\"预录取\";i:4;s:4:\"录取\";i:3;s:8:\"没有录取\";i:2;s:4:\"其他\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','42','','','','','请填入录取状态');
REPLACE INTO `p8_forms_model_field` VALUES ('788','bybd6','0','beizhu','备注','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"70\" rows=\"6\"','40','','','','','如有备注，请填写');
REPLACE INTO `p8_forms_model_field` VALUES ('789','bybd6','0','cplx','性别','varchar','','0','0','0','1','255','0','1','0','','a:2:{i:1;s:2:\"男\";i:3;s:2:\"女\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','59','','','','','请选择性别');
REPLACE INTO `p8_forms_model_field` VALUES ('790','bybd6','0','cpmc','姓名','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','style=\"width:205px;border:1px soild #ff0000\"','60','','','','','请输入考生姓名');
REPLACE INTO `p8_forms_model_field` VALUES ('791','bybd6','0','date','录取日期','varchar','','1','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textdate','','48','','','','','请选择录取日期');
REPLACE INTO `p8_forms_model_field` VALUES ('792','bybd6','0','hgcp','邮寄地址','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','44','','','','','请填入邮寄地址');
REPLACE INTO `p8_forms_model_field` VALUES ('793','bybd6','0','nianfen','录取专业','varchar','','0','0','0','1','255','0','1','0','','a:3:{i:1;s:12:\"电子信息工程\";i:2;s:14:\"计算机科与技术\";i:3;s:8:\"土木工程\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','51','','','','','请选择录取专业');
REPLACE INTO `p8_forms_model_field` VALUES ('794','bybd6','0','sjsl','EMS编号','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','46','','','','','请填入快递编号');
REPLACE INTO `p8_forms_model_field` VALUES ('795','bybd6','0','tibaoren','考生号','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','style=\"width:205px;border:1px soild #ff0000\"','55','','','','','请填入考生号');
REPLACE INTO `p8_forms_model_field` VALUES ('796','bybd6','0','yuefen','层次','varchar','','0','0','0','1','255','0','1','0','','a:4:{i:1;s:4:\"硕士\";i:2;s:4:\"本科\";i:3;s:4:\"专科\";i:4;s:4:\"其他\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','50','','','','','请选择录取层次');
REPLACE INTO `p8_forms_model_field` VALUES ('858','peixunfangang','0','sex','性别','varchar','','0','0','0','1','255','0','1','0','男','a:2:{s:3:\"男\";s:3:\"男\";s:3:\"女\";s:3:\"女\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','radio','','59','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('859','peixunfangang','0','email','电子邮件','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','30','','/^[w-.]+@[w-.]+(.w+)+$/','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('863','yuyue','0','name','单位名称','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('865','yuyue','0','select','产品分类','varchar','','0','0','0','1','255','0','1','0','','a:3:{i:1;s:9:\"产品一\";i:2;s:9:\"产品二\";i:3;s:9:\"产品三\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','class=\"set\"','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('866','yuyue','0','phone','手机号码','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('867','yuyue','0','mailbox','联系邮箱','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('868','yuyue','0','content','留言内容','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','','0','','','','','');
REPLACE INTO `p8_config` VALUES ('core','forms','string','htmlize','0');
REPLACE INTO `p8_config` VALUES ('core','forms','string','html_post_url_rule','{$module_url}/{$name}.html');
REPLACE INTO `p8_config` VALUES ('core','forms','string','dynamic_list_url_rule','{$module_controller}-list-mid-{$id}#-page-{$page}#.html');
REPLACE INTO `p8_config` VALUES ('core','forms','string','dynamic_view_url_rule','{$module_controller}-view-id-{$id}.html');
REPLACE INTO `p8_config` VALUES ('core','forms','string','html_list_url_rule','{$module_url}/list_{$id}#-page-{$page}#html');
REPLACE INTO `p8_config` VALUES ('core','forms','string','html_view_url_rule','{$module_url}/{$id}.html');
REPLACE INTO `p8_config` VALUES ('core','forms','serialize','status','a:4:{i:-1;s:4:\"退返\";i:0;s:6:\"未处理\";i:1;s:6:\"处理中\";i:9;s:6:\"己处理\";}');
REPLACE INTO `p8_config` VALUES ('core','forms','string','view_page_cache_ttl','0');