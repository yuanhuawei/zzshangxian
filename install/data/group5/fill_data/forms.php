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

REPLACE INTO `p8_forms_item` VALUES ('94','�������̶��ձ�','','16','1','admin','219.136.170.160','0','1300257178','1306894495','1306894495','1','0','9','admin','1301793974','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('116','�������̶��ձ�','','16','7','�Ź�΢','219.136.143.11','0','1300953782','1307420744','1307420744','1','0','9','admin','1301793974','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('123','�������̶��ձ�','','16','7','�Ź�΢','113.103.4.224','0','1301583011','0','1301583011','1','0','9','admin','1301793974','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('140','�������̶��ձ�','','16','7','�Ź�΢','61.140.172.30','0','1301794054','1307527129','1307527129','0','0','9','admin','1301794078','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('139','�������̶��ձ�','','16','1','admin','219.136.143.147','0','1301735330','1302325091','1302325091','0','0','9','admin','1301793974','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('214','���õ绰','','27','1','admin','219.136.169.139','0','1306896387','0','1306896387','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('219','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307437808','1307527189','1307527189','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('220','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307437935','1307527212','1307527212','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('221','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307437973','1307527233','1307527233','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('222','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307438058','1307527252','1307527252','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('223','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307438104','1307527277','1307527277','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('224','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307438140','1307528322','1307528322','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('225','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307438267','1307527313','1307527313','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('226','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307438300','1307527328','1307527328','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('227','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307438605','1307527372','1307527372','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('228','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307438652','1307527389','1307527389','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('229','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307439335','1307527413','1307527413','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('230','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307439363','1307527451','1307527451','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('231','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307439499','1307527480','1307527480','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('232','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307439547','1307527497','1307527497','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('233','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307439635','1307527515','1307527515','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('234','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307439663','1307527600','1307527600','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('235','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307439707','1307527949','1307527949','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('236','���̲�ѯƽ̨','','16','1','admin','219.135.216.86','0','1307439764','1329102115','1329102115','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('237','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307439802','1307527648','1307527648','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('238','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307439914','1307527673','1307527673','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('239','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307439942','1307527693','1307527693','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('240','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307440219','1307527725','1307527725','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('241','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307440350','1307527757','1307527757','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('242','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307440406','1307527774','1307527774','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('243','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307440540','1307527790','1307527790','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('244','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307440564','1307527807','1307527807','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('245','�������̶��ձ�','','16','1','admin','219.135.216.86','0','1307440604','1307527834','1307527834','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('246','�ⲿ���õ绰','','27','1','admin','219.135.216.86','0','1307441172','1307498710','1307498710','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('247','���̲�ѯƽ̨','','16','1','admin','219.135.216.86','0','1307443695','1329550522','1329550522','0','0','0','admin','1330613717','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('253','�������̶��ձ�','','16','1','admin','219.136.138.145','0','1307528811','0','1307528811','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('254','�������̶��ձ�','','16','1','admin','219.136.138.145','0','1307528915','0','1307528915','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('255','�������̶��ձ�','','16','1','admin','219.136.138.145','0','1307529294','0','1307529294','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('276','ר�������������ռ�','','47','1','admin','219.136.141.57','0','1309832790','0','1309832790','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('270','�������̶��ձ�','','16','7','�Ź�΢','202.102.194.78','0','1309166233','0','1309166233','0','0','9','admin','1309756089','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('282','���̲�ѯƽ̨','','16','7','�Ź�΢','113.109.12.241','0','1310189212','1329989996','1329989996','0','0','9','admin','1310210463','0','   ͬ�⡣312');
REPLACE INTO `p8_forms_item` VALUES ('285','�������̶��ձ�','','16','94','�Ŵ�ȫ','61.144.102.51','0','1310268204','0','1310268204','0','0','99','admin','1330438916','0','');
REPLACE INTO `p8_forms_item` VALUES ('337','�������̶��ձ�','','16','1','admin','61.144.102.51','0','1310280436','0','1310280436','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('338','�������̶��ձ�','','16','1','admin','61.144.102.51','0','1310280436','0','1310280436','0','0','99','admin','1330743781','0','');
REPLACE INTO `p8_forms_item` VALUES ('339','���̲�ѯƽ̨','','16','1','admin','61.144.102.51','0','1310280436','1329129686','1329129686','0','0','99','admin','1330743925','0','');
REPLACE INTO `p8_forms_item` VALUES ('371','���̲�ѯƽ̨','','16','102','�ƿ�','219.136.136.46','0','1310360610','1329991288','1329991288','0','0','9','���','1329991266','0',' OK');
REPLACE INTO `p8_forms_item` VALUES ('377','�ⲿ���õ绰','','27','7','�Ź�΢','113.77.40.54','0','1311315354','1315846528','1315846528','0','0','1','admin','1367074776','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('442','��Ƹƽ̨','','78','1','admin','175.13.252.30','0','1468566022','0','1468566022','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('416','���̲�ѯƽ̨','','16','101','���','113.103.0.236','0','1329991222','0','1329991222','0','0','0','admin','1330613746','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('423','���̲�ѯƽ̨','','16','1','admin','61.144.102.110','0','1330606166','0','1330606166','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('432','ѧԺ���õ绰','','27','0','','119.141.101.47','0','1398868416','0','1398868416','0','0','0','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('433','Ͷ�߽���','','4','0','','119.141.101.47','0','1398868488','0','1398868488','0','0','0','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('434','Ͷ�߽���','','4','0','','119.141.101.47','0','1398868539','0','1398868539','0','0','0','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('443','Ͷ�߽���','','4','1','admin','120.86.68.203','0','1505660602','0','1505660602','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('444','Ͷ�߽���','','4','1','admin','113.247.53.255','0','1505660821','0','1505660821','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('445','��Ƹƽ̨','','78','0','','113.246.93.129','0','1507514597','0','1507514597','0','0','9','admin','1507514624','0',' ');
REPLACE INTO `p8_forms_item` VALUES ('446','Ͷ�߽���','','4','1','admin','113.246.93.129','0','1507521949','0','1507521949','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('447','��ҪӦƸ','','77','1','admin','113.246.93.129','0','1507531753','0','1507531753','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item` VALUES ('448','����ԤԼ','','79','15','admin2','113.246.87.78','0','1520499319','0','1520499319','0','0','9','','0','0','');
REPLACE INTO `p8_forms_item_banshi` VALUES ('94','���ϲɹ��۸�����','1','������','15989052365/020-2695896','������ڸ��Ŵ��&lt;br /&gt;\r\n23342333\r\nwerwerewe\r\nsdfsdafsd\r\nsdfsfs\r\nfsdfdsfdfds','','http://www.php168.net/','C1005811','ArrayArrayArray','');
REPLACE INTO `p8_forms_item_banshi` VALUES ('116','���ñ�������','1','��С��','020-4567894/13989568945','���ᱨ��������---���õ��ݺ��ύ�����񲿣�ÿ��һ��','','http://nw.php168.net/index.php','C1005815','2.2.jpg<!--#p8_attach#-->/core/forms/2011_06/07_10/d03c19b8d4211b00.jpg.cthumb.jpg<!--#p8_attach#-->/core/f2.2.jpg<!--#p8_attach#-->/core/forms/2011_06/07_10/d03c19b8d4211b00.jpg.cthumb.jpg<!--#p8_attach#-->/core/forms/2011_06/07_10/d03c19b8d4211b00.jpg.thumb.jpg','');
REPLACE INTO `p8_forms_item_banshi` VALUES ('123','����칫�ľ�����','1','��С��','020-2356898','����----��д��---��ȡ','','','C1005819','','');
REPLACE INTO `p8_forms_item_banshi` VALUES ('139','����˾ʳ�÷���','2','����','15987654321','���쵼������ֱ�ӵ���������ȡ','','www.php168.net','G123213213','','');
REPLACE INTO `p8_forms_item_banshi` VALUES ('140','������ҵ����','1','��С��','020-25658945','122','11.jpg<!--#p8_attach#-->/core/forms/2011_04/04_21/471ff7edcbfa9367.jpg','http://php168.net','L001','Array<!--#p8_attach#-->/core/forms/2011_06/07_10/d03c19b8d4211b00.jpg.cthumb.jpg<!--#p8_attach#-->/core/forms/2011_06/07_10/d03c19b8d4211b00.jpg.thumb.jpg1244475966482206928.jpg<!--#p8_attach#-->/core/forms/2011_06/07_10/edabc94527652720.jpg.cthumb.jpg<!--#p8_attach#-->/core/forms/2011_06/07_10/edabc94527652720.jpg.thumb.jpg','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('219','��ҵ��������','1','***','******/*******','','','http://','L001','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('220','����ʹ������','1','***','******/*******','','','http://','L002','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('221','��ͬ�鵵�����','1','***','******/*******','','','http://','L003','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('222','ֵ���ѯ������','1','***','******/*******','','','http://','L004','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('223','ֵ��ȷ�������','1','***','******/*******','','','http://','L005','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('224','��������IT����','1','***','******/*******','','','http://','L006','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('225','�����౨������','1','***','******/*******','','','http://','L007','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('226','���ֻ�౨��','1','***','******/*******','','','http://','L008','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('227','���ʲ�ѯ��ǩ�ա������޸�','1','***','*******/******','','','http://','L009','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('228','�����޸�/����Excel����','1','***','*******/******','','','http://','L010','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('229','���ñ�������������','1','***','*******/******','','','http://','L011','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('230','��Ӧ�̸�������������','1','***','*******/******','','','http://','L012','','7');
REPLACE INTO `p8_forms_item_banshi` VALUES ('231','�������۶����տ�ȷ��','1','***','*******/******','','','http://','L013','','12');
REPLACE INTO `p8_forms_item_banshi` VALUES ('232','��ҵ������������','1','***','*******/******','','','http://','L014','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('233','�ʼ����¼����ʹ��','1','***','*******/******','','','http://','L015','','11');
REPLACE INTO `p8_forms_item_banshi` VALUES ('234','�ֿ���������','1','***','*******/******','','','http://','L016','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('235','�ֿ����Ϸ�������','1','***','*******/******','','','http://','L017','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('236','BOM��������������','1','***','*******/******','234234342','','http://','L018','zlpt2.gif<!--#p8_attach#-->/core/forms/2012_02/13_11/e98c121dee5ed8b6.gif<!--#p8_attach#-->/core/forms/2012_02/13_11/e98c121dee5ed8b6.gif','4');
REPLACE INTO `p8_forms_item_banshi` VALUES ('237','�з����Ϲ���������','1','***','*******/******','','','http://','L019','','4');
REPLACE INTO `p8_forms_item_banshi` VALUES ('238','�����ƻ��������ѯ��','1','***','*******/******','','','http://','L020','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('239','��������ÿ�յǼ�','1','***','*******/******','','','http://','L021','','8');
REPLACE INTO `p8_forms_item_banshi` VALUES ('240','�ɹ�������ִ�в鿴','1','***','*******/******','','','http://','L022','','7');
REPLACE INTO `p8_forms_item_banshi` VALUES ('241','�ɹ��۸�ƽ̨��������','1','***','*******/******','','','http://','L023','','7');
REPLACE INTO `p8_forms_item_banshi` VALUES ('242','��Ӧ������/�޸�����','1','***','*******/******','','','http://','L024','','7');
REPLACE INTO `p8_forms_item_banshi` VALUES ('243','������Ϣ���ᱨ�����','1','***','*******/******','','','http://','L025','','5');
REPLACE INTO `p8_forms_item_banshi` VALUES ('244','���ۿͻ������ᱨ�����','1','***','*******/******','','','http://','L026','','5');
REPLACE INTO `p8_forms_item_banshi` VALUES ('245','���۳ɽ������ᱨ�����','1','***','*******/******','','','http://','L026','','5');
REPLACE INTO `p8_forms_item_banshi` VALUES ('247','�ۺ�ƽ̨ʹ�ý̳�','1','***','******/*******','','','http://','L027','dingcan.gif<!--#p8_attach#-->/core/forms/2012_02/18_15/43d6dbc414aca806.gif<!--#p8_attach#-->/core/forms/2012_02/18_15/43d6dbc414aca806.gifwenju.gif<!--#p8_attach#-->/core/forms/2012_02/18_15/5d3ce2e7d2781b87.gif<!--#p8_attach#-->/core/forms/2012_02/18_15/5d3ce2e7d2781b87.gif','6');
REPLACE INTO `p8_forms_item_banshi` VALUES ('253','���߰��½����ѯ����֤','1','***','*******/******','','','','L028','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('254','��ҵ�᰸����','1','***','*******/******','','','','L029','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('255','�����ʼ��Ϳ������','1','***','*******/******','','','','L030','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('270','��ҵ����','1','222','222222','','','','L00111','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('282','��ȡ��˾����','2','����','1236454655','Ա������дһ���������������������������� 4234343@163.com��Ȼ�������Լ������֤��ȥ���������������״η�����ֵ����100Ԫ�����ⷹ����10Ԫ�����ѡ�','���������<!--#p8_attach#-->/core/forms/2012_02/23_17/d7a2174ed38a939a.doc','http://php168.net','L031','55555.jpg<!--#p8_attach#-->/core/forms/2012_02/23_17/fe9eccea5caebc10.jpg<!--#p8_attach#-->/core/forms/2012_02/23_17/fe9eccea5caebc10.jpg.thumb.jpg','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('285','�����籣����','1','�Ŵ�','1212313254654','*********************************','','','L032','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('337','�����������','1','����','135222222','���������Լ���д','Array','','L051','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('371','23432432','1','23423','23432','4234324343223wwerwe','','http://','234342','','3');
REPLACE INTO `p8_forms_item_banshi` VALUES ('338','�ͻ������������','1','����','136000000','���������Լ���д','Array','','L052','','5');
REPLACE INTO `p8_forms_item_banshi` VALUES ('339','�ͻ��ۺ�����','1','����','138000000','���������Լ���д','Array','http://','L053','gdzc.gif<!--#p8_attach#-->/core/forms/2012_02/13_18/c0794b873d2fa79a.gif<!--#p8_attach#-->/core/forms/2012_02/13_18/c0794b873d2fa79a.gif','6');
REPLACE INTO `p8_forms_item_banshi` VALUES ('416','ertr','1','443535','34535343533','erterterert','','htt://php168.net','L888','','1');
REPLACE INTO `p8_forms_item_banshi` VALUES ('423','234234','1','23423','234234','23432','','','23423','','2');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('40','2','����','8','2','6','1','20','180','1','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('41','3','����','5','2','2','1','0','0','4','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('42','7','�ޱ�ѫ','15','4','12','2','20','100','1','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('43','11','�λ���','5','2','5','2','20','50','2','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('44','8','��ʩ��','4','2','4','1','10','20','3','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('45','15','�޾�','7','2','6','2','23','89','2','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('46','12','����','2','3','2','1','12','35','3','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('47','5','����','20','2','20','1','50','160','1','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('63','3','����','0','3','0','1','12','0','1','');
REPLACE INTO `p8_forms_item_bmjx` VALUES ('64','5','��ΰ��','1','2','1','2','0','0','2','1200');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('10','1','ĳ��','12','2','3','4','5','6','345','2','0','0','0','0','0','0','0','2','2','0','456345645','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('34','15','�λ���','12','5','4','2','1','1','1500','2','0','0','0','0','0','0','0','1','1','50','231321','2','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('35','8','������','12','6','3','1','1','1','860','2','0','0','0','0','0','0','0','2','2','0','654645645','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('36','1','�ޱ�','12','1','1','0','0','1','50','1','0','0','0','0','0','0','0','2','1','0','456646','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('37','16','����','12','2','2','1','5','1','200','2','3','2','4','200','50','60','40','3','','10','56456456','2','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('38','9','������','12','3','3','2','1','0','670','2','0','0','0','0','0','0','0','1','2','0','4564564','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('39','6','��˿��','12','3','3','2','1','5','700','1','4','5','4','4','50','50','50','2','1','500','5464564','2','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('65','4','��С��','3','15','13','5','3','5','300','1','0','0','0','0','0','0','0','1','1','0','46564','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('66','6','����','3','5','5','3','2','0','500','1','0','0','0','0','0','0','0','1','1','0','4454','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('67','10','ëС��','3','10','5','1','4','2','500','1','0','0','0','0','0','0','0','1','1','0','�ķ�����','1','0','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('151','4','�淶��','4','234','32','234','234','234','234','2','56','46','45','234','56','343','234','1','1','678','1231231','1','5678','');
REPLACE INTO `p8_forms_item_bmtajx` VALUES ('154','3','fgh','3','45','45','0','0','0','0','2','0','10','10','200','200','100','400','1','1','456','sdfsdfsdf','2','560','');
REPLACE INTO `p8_forms_item_bom` VALUES ('88','48pF����','02030405','48PCS','14','1','1000PCS','1','������','020-2356489','ƻ�������.rar<!--#p8_attach#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','123123','','2');
REPLACE INTO `p8_forms_item_bom` VALUES ('89','MTD2955VоƬ','0203156','5PCS','60','1','100PCS','1','������','020-2356489','ƻ�������.rar<!--#p8_attach#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','21321321','','2');
REPLACE INTO `p8_forms_item_bom` VALUES ('90','BC849BLT1GоƬ','02030506','5PCS','60','1','50PCS','1','������','020-2356489','','','','2');
REPLACE INTO `p8_forms_item_bom` VALUES ('91','33k����','02030509','100000PCS','0','1','10000PCS','2','������','020-2356489','ƻ�������.rar<!--#p8_attach#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','','','2');
REPLACE INTO `p8_forms_item_bom` VALUES ('92','����','020308','1PCS','50','3','100PCS','2',' ������','020-2356489','ƻ�������.rar<!--#p8_attach#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','','','2');
REPLACE INTO `p8_forms_item_bom` VALUES ('130','��ʾ��','02050648','1̨','20','1','10̨','2','������','020-2356489','','','','2');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('18','��С��','3','����OK','3213123','2132112312','2','2132321','2321','120','2321','3','','');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('19','�ź�','6','423423','234234','2342323432','2','32423','23423','500','2343','3','','');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('20','������','4','234234','234234','','3','2476800','57600','324','34234','3','','�����');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('21','������','9','234234','23444564564556','','3','1785600','-28800','100','','3','','�����');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('22','������','1','23432','23432432','','1','1872000','','200','','1','','������');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('23','������','11','324234','234234','','2','1785600','-28800','300','','1','','�����');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('24','������','5','23423','2342323','','1','2563200','-28800','10','','1','','������');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('82','������','5','�����豸��˿ѡ������','��ϸ���ݿ�����','','2','-28800','-28800','100','21323','3','','�����');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('81','����÷','7','��θ�����Ʒ׼ȷ�Ե��᰸','������Ʒ׼ȷ�Ե��᰸','','3','2563200','-28800','50','www.php168.net','3','','�����');
REPLACE INTO `p8_forms_item_bumengtiang` VALUES ('83','��С��','3','��μӴ����۲��Ĵ����̹���','�μӴ����۲��Ĵ����̹�����������','','3','1300982400','1299772800','100','12312','3','���������ģ�����','�����');
REPLACE INTO `p8_forms_item_bybd1` VALUES ('372','345345','345435','1','1309795200','34543','2','34534534','','34534');
REPLACE INTO `p8_forms_item_bybd2` VALUES ('214','������','��С��','10','110','��','��','','�㶫ʡ������������','www.php168.net','');
REPLACE INTO `p8_forms_item_bybd2` VALUES ('246','��˾������','***','13','********/*******','***********','***********','','','http://','');
REPLACE INTO `p8_forms_item_bybd2` VALUES ('377','aa','aa','2','aa','111111','','','','http://','');
REPLACE INTO `p8_forms_item_bybd2` VALUES ('432','3423r','dfasdfd','1','432543556546','4543543','43543@12.com','','','','');
REPLACE INTO `p8_forms_item_bybd3` VALUES ('419','345','34534535','1','1330358400','34534','');
REPLACE INTO `p8_forms_item_bybd3` VALUES ('274','dds','ddd','1','1318867200','','');
REPLACE INTO `p8_forms_item_bybd3` VALUES ('370','312312','123123','1','1310313600','','');
REPLACE INTO `p8_forms_item_bybd3` VALUES ('381','21321','213','1','1314806400','','');
REPLACE INTO `p8_forms_item_bybd3` VALUES ('385','1112','1122','1','1318348800','','');
REPLACE INTO `p8_forms_item_bybd4` VALUES ('368','23432','1','23423','23423');
REPLACE INTO `p8_forms_item_bybd4` VALUES ('383','����','2','�������� ','�����뱨������  ��ά�����豸��������״�������� fgdf');
REPLACE INTO `p8_forms_item_bybd4` VALUES ('387','000000','3','00000','000000000000000');
REPLACE INTO `p8_forms_item_bybd4` VALUES ('417','��־��','2','���Բ�������',' ����������������Դ�ˡ�');
REPLACE INTO `p8_forms_item_bybd4` VALUES ('418','��̨��','1','��Ϊ�ж�','��ζ��������ζ��');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('388','erwerq','','0','0','0','','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('389','','','0','0','0','1','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('390','','','0','0','0','','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('391','','','0','0','0','','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('392','��ĳ��','','0','0','0','','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('393','��ĳ��','','0','0','0','1','','�����ҵ��ˣ�ˢ������������û��ǩ����');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('394','��ĳ��','','0','0','0','','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('395','��ĳ��','','0','0','0','1','','�����ҵ��ˣ�ˢ������������û��ǩ����');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('396','��ĳ��','','0','0','0','','','');
REPLACE INTO `p8_forms_item_bybd7` VALUES ('397','��ĳ��','','0','0','0','1','10','�����ҵ��ˣ�ˢ������������û��ǩ����');
REPLACE INTO `p8_forms_item_caigougongzhang` VALUES ('165','678678768','3','67867876867','86786786','','67867867','867867867');
REPLACE INTO `p8_forms_item_caigougongzhang` VALUES ('157','S1001','1','����Ϊ�ξ���������ԭ��','1��ͻȻ������2:��ͻȻ������3:��ͻȻ����','ƻ�������.rar<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','��','HP����');
REPLACE INTO `p8_forms_item_caigougongzhang` VALUES ('164','67867876','1','568675','568678676876','','576868678','6867');
REPLACE INTO `p8_forms_item_caigougongzhang` VALUES ('166','786786','1','678678','678678','','67867','678678');
REPLACE INTO `p8_forms_item_canpinjc` VALUES ('115','���','N1002255','��ѹ��Դ�����ñ�','������ѹ��Դ0.75-1.6V��������������ת','','ƻ�������.rar<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','%e6%88%bf%e5%9c%b0%e4%ba%a71111.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/23_15/ac4814950239c868.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/23_15/ac4814950239c868.jpg.thumb.jpg','ëС��','','','1','1');
REPLACE INTO `p8_forms_item_canpinjc` VALUES ('132','����','02030405','�¶ȼ�','12312312��ʿ���˵��','','','','23432','','','1','2');
REPLACE INTO `p8_forms_item_canpinjc` VALUES ('367','23324','2423432','23423','23423423423','','','','234234','','','2','2');
REPLACE INTO `p8_forms_item_cgbbd` VALUES ('427','324','23423423','423423423','','','','','');
REPLACE INTO `p8_forms_item_cgjhxq` VALUES ('215','HP����','0201006','2̨','2','1307376000','X20110506001','S20111056001','���۲�������Ա','��С��','1','1','','');
REPLACE INTO `p8_forms_item_cgjhxq` VALUES ('363','23423','4234234','234234','1','1310313600','23423','234234','23423','23423423','2','1','23423424','');
REPLACE INTO `p8_forms_item_ckslfl` VALUES ('216','���','1214454454','1','1','4','1306857600','�Ͽƴ�','N4565654','500��','420��','','','','','','','','','','','');
REPLACE INTO `p8_forms_item_ckslfl` VALUES ('252','��˿��0406','0203002','3','1','6','1307462400','','','','','','','','','','5�·ݿ����5200��','5�·ݹ�����1000��','','','','5�µ׿��800��');
REPLACE INTO `p8_forms_item_ckslfl` VALUES ('365','312','2312','1','1','3','1310313600','12312','12321','312321','321312','312312','','','','','','','','','12321','');
REPLACE INTO `p8_forms_item_ckslfl` VALUES ('366','234234','234234','1','3','3','1310313600','234234','234234','234234','234234','32432432','','','','','','','','','23423','');
REPLACE INTO `p8_forms_item_dangweixingzhen` VALUES ('441','20101122057344588691.jpg<!--#p8_attach#-->/core/forms/2014_11/10_10/e6bbe167bee26e8b.jpg<!--#p8_attach#-->/core/forms/2014_11/10_11/216db2eace30c53f.jpg.thumb.jpg','���гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ�','1245c211m@qq.com','������','��ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ����ʦ���','����¥A-505','������ ����Ⱥ�ı�ʾ��');
REPLACE INTO `p8_forms_item_dingcang` VALUES ('425','42','23423','1','234','234','2','342','23423','234','234');
REPLACE INTO `p8_forms_item_dlxstc` VALUES ('49','�Ϸ��Ƽ�','����','23423','5666','4545','1','345345','','1','4','123456');
REPLACE INTO `p8_forms_item_gdzc` VALUES ('93','���յ���-N001','020106','2','��С��','5000','1236787200','1','1300204800','��ï��','���յ���<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/240d3c9932a9eae6.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/240d3c9932a9eae6.jpg.thumb.jpg','ƻ�������.rar<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','213123','','');
REPLACE INTO `p8_forms_item_gdzc` VALUES ('129','��������','G020108','4','�λ���','500000','924796800','1','1301587200','��С��','%e6%88%bf%e5%9c%b0%e4%ba%a71111.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/23_15/ac4814950239c868.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/23_15/ac4814950239c868.jpg.thumb.jpg','ƻ�������.rar<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','','','');
REPLACE INTO `p8_forms_item_gdzc` VALUES ('150','��ӡ��','G201526','5','������','5000','1238601600','1','1301846400','����','11.jpg<!--#p8_r_attach1#-->/core/forms/2011_04/04_21/471ff7edcbfa9367.jpg<!--#p8_r_attach1#-->/core/forms/2011_04/04_21/471ff7edcbfa9367.jpg.thumb.jpg','','','','��С��');
REPLACE INTO `p8_forms_item_gongzi` VALUES ('172','��־ӱ','2','5','','1024','','0','php168.net','1','5588','1306857600','','','','');
REPLACE INTO `p8_forms_item_gongzi` VALUES ('173','��־','1','1','','370202198210104536','','0','654321','1','5588','1306857600','2102','1','1304265600','');
REPLACE INTO `p8_forms_item_gysfk` VALUES ('114','��΢���','N1005','2','1302624000','������','�ȴ�����','','');
REPLACE INTO `p8_forms_item_gysfk` VALUES ('133','��һ�ع�','020604','2','1303315200','��Сë','�Ѿ�֧��','','');
REPLACE INTO `p8_forms_item_gysfk` VALUES ('134','Эͬ����','020604','2','1304006400','������','����','','');
REPLACE INTO `p8_forms_item_gysfk` VALUES ('160','�ֶ���','3242342342','1','','43534','','','');
REPLACE INTO `p8_forms_item_gysfk` VALUES ('356','213132','12321','1','1310313600','21321','','','');
REPLACE INTO `p8_forms_item_gzqs` VALUES ('281','123','2','1','2','1','1','2345','3455','5','5');
REPLACE INTO `p8_forms_item_huodongbm` VALUES ('118','������','3','020-26598956565','1245786545','2','ϣ�����뵽�������','');
REPLACE INTO `p8_forms_item_huodongbm` VALUES ('266','sdfsdfsd','6','212312312','0','1','sdsdas','');
REPLACE INTO `p8_forms_item_huodongbm` VALUES ('273','234324','2','234234','0','1','234234','');
REPLACE INTO `p8_forms_item_huodongbm` VALUES ('343','2342343','2','23423432','0','1','234234342234234','');
REPLACE INTO `p8_forms_item_jdbbd` VALUES ('429','����','1','','','15989523698','dfsdfdsfs@163.com','����02-1','2','ѧϰ����');
REPLACE INTO `p8_forms_item_jiangshi` VALUES ('440','201122710224574742.gif<!--#p8_attach#-->/core/forms/2014_11/10_13/64e19f9df6d8fff1.gif<!--#p8_attach#-->/core/forms/2014_11/10_13/64e19f9df6d8fff1.gif.thumb.jpg','1.<a href=\"http://www.ams.org/mathscinet/search/publications.html?pg1=IID&amp;s1=660135\">Li, Shu Hai</a>; <a href=\"http://www.ams.org/mathscinet/search/publications.html?pg1=IID&amp;s1=790063\">Dai, Jin Jun</a>; <a href=\"http://www.ams.org/mathscinet/searc','jjdai@mail.ccnu.edu.cn','����','ѧϰ������<br />\r\n&nbsp;&nbsp; 2000~2005&nbsp;&nbsp;&nbsp; �人��ѧ��ѧ��ͳ��ѧԺ&nbsp;&nbsp;������ѧרҵ&nbsp; &nbsp;��ʿѧλ��<br />\r\n&nbsp;&nbsp; 1996~2000&nbsp;&nbsp;&nbsp; �й�ʯ�ʹ�ѧ(����) ��ѧԺ&nbsp;&nbsp; ������ѧ��Ӧ�����רҵ&nbsp; ��ѧʿѧλ��<br />\r\n����������<br />\r\n&nbsp;&nbsp; 2005~��&nbsp;&nbsp;&','����¥A-507','������ ����Ⱥ�ı�ʾ��');
REPLACE INTO `p8_forms_item_jiaoshou` VALUES ('437','����˼','�о������о������о������о�����','���гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ����гɹ�','1245commm@qq.com','����¥A-508','11.jpg<!--#p8_attach#-->/core/forms/2015_01/10_12/96307c04c047f17c.jpg<!--#p8_attach#-->/core/forms/2015_01/10_12/96307c04c047f17c.jpg.thumb.jpg','2343');
REPLACE INTO `p8_forms_item_jiaoshou` VALUES ('438','������','��������硢�Ƽ��㡢���ܼ�������Ϣ����ͳ��Ӧ��','������Ŀ��<br />\r\n1.������Ŀ�������о���ũ��Ʒ������ȫ���ϵͳ�����ҿƼ�������Ŀ���2011GB2D10002��<br />\r\n2.������Ŀ�������о�����̬���绷���µķ�����ϡ��ؽ����Ż����о���������Ȼ��ѧ���𣬺�������Ŀ��׼�ţ�61070182��<br />\r\n3.�����о������绷���µķ������Ļ��������о���������Ȼ��ѧ���𣬺�������Ŀ��׼�ţ�60873192��<br />\r\n4.�����о������绷��������Ӧ������Ϲؼ������о���������Ȼ��ѧ���𣬺�������Ŀ��׼�ţ�60873193','cldong@mail.ccnu.edu.cn','����¥A-507','11.jpg<!--#p8_attach#-->/core/forms/2015_01/10_12/96307c04c047f17c.jpg<!--#p8_attach#-->/core/forms/2015_01/10_12/96307c04c047f17c.jpg','�����֣�1963��6��16�����ں���ʡ�人�У����ڡ�<br />\r\n���пƼ���ѧ����ѧԺ��ʿ��ҵ�������ѧ�빤�̷��򣩡�<br />\r\n�й��ֳ�ͳ���о�����Դ�뻷��ͳ�Ʒ᳣ֻ�����¡�<br />\r\n�绰��13307173822<br />\r\n�����ʼ���<a href=\"mailto:cldong@mail.ccnu.edu.cn\">cldong@mail.ccnu.edu.cn</a>');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('1','������','2','http://nw.php168.net/index.php','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('2','С����','1','http://nw.php168.net/index.php','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('9','������','5','6','30','456','1','3','2','5','20','20','200','5','6','2','0','0','3000','30','200','1000','1','300');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('14','����','1','2','10','300','1','0','0','0','0','100','0','12','8','0','0','0','600','3','100','3000','1','1500');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('16','����','1','1','12','100','1','1','1','0','0','20','0','10','8','2','0','0','500','0','0','1620','1','300');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('53','������','3','3','56','560','1','0','0','2','48','100','10','3','2','0','0','0','300','0','0','200','','120');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('54','������','8','3','0','0','1','0','0','0','0','50','0','1','1','1','0','0','200','12','36','3500','1','1000');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('55','������','12','3','5','100','2','5','0','2','48','80','15','3','3','2','1','0','500','0','0','1860','2','150');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('56','��ˮ��','8','3','3','60','1','0','0','0','0','100','10','0','2','0','0','0','100','0','0','1500','1','200');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('59','�κö�','5','3','5','100','2','3','0','1','2','100','20','5','4','3','0','1','300','0','0','2300','1','1000');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('60','������','11','3','0','0','1','0','0','0','2','100','5','5','2','0','0','0','250','0','0','1500','3','150');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('61','�ź�Ȼ','8','3','5','100','2','5','2','2','48','100','20','1','1','0','0','1','20','1','10','1200','2','500');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('62','������','6','3','2','40','2','2','1','0','0','150','13','2','2','1','0','1','300','0','0','300','3','50');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('265','dd','1','1','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','0');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('378','Ҫ','1','1','0','0','1','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','0');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('384','���ط���˵��','1','1','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','0');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('400','123','1','1','0','0','2','31','31','31','31','0','9000','0','0','0','0','0','0','0','0','0','','0');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('405','����','1','1','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','0');
REPLACE INTO `p8_forms_item_jixiaobiaoyan` VALUES ('406','232323','1','2','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','0');
REPLACE INTO `p8_forms_item_kehu` VALUES ('442','','1','30','1489593600','23432','1','23434324232332','234','432','32432','1','1','1','2343232','2343','3242','23432','23432','234','23432','2','1','','93364-33379');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('206','������','1','5','1305820800','���ݹ�΢���','������','020-25698785','N23434234232','�����΢��ҵ��������','2800','2','0','','','','');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('207','��С��','1','5','1305648000','��������ʯ��','�о���','1598528555','N8988988989','�����΢��ҵ��Ϣ����Ʒ','120000','1','0','','','','');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('213','d','1','1','1304179200','111','11','1111','11111','11111111','1111','1','0','','','','');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('359','2343242','1','3','1310313600','23432','234234','','234234','3243232','23423','1','0','','','','');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('401','CFbpKFrDKf','7','2','lWKflFBxKSsBubNkmyq','HFYEybYGjz','MLuRaDlBd','pMBsnUvZ','xrITahaaJUyfFMe','Thanks for writing such an easy-to-understand atrilce on this topic.','DtDZJbOBXyDmFSFBJjMhttp://www.facebook.com/profile.php?id=100003405859828','3','0','','','','');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('402','HhqCNJlna','9','5','XrdBbwoVkcTS','fORKurQSxplMsUB','ooiBpFIw','dbLSGRBVh','kIpTCvdAvuGQP','You got to push it-this eessntial info that is!','sbZTbjKeQhttp://www.facebook.com/profile.php?id=100003405882853','2','0','','','','');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('404','��С��','1373385600','1','��С��','��С����С����С����С����С����С��','43232!@2143.com','14352565465','��С��','dasfdsafsadfsdfsadfsad','','2','123456','323532432432','1','4564rterwtew','dasfdsafsadfsdfsadfsaddasfdsafsadfsdfsadfsaddasfdsafsadfsdfsadfsad');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('405','23423','1374076800','2','234','23423','23423','2342','2342','','','3','12345678','23423','1','23432','23423432');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('406','23423','1397491200','1','23423','23423','23423','3423','23423','������','','2','123456','234234','1','23423','������');
REPLACE INTO `p8_forms_item_kehucj` VALUES ('407','23423423','1403020800','','23423','23423432','23423','23423','23423','23423423342','','','2343','234234','1','23423','23423');
REPLACE INTO `p8_forms_item_kq` VALUES ('374','������','3','2','1','1309190400','2342','23423423423','23423','','','','');
REPLACE INTO `p8_forms_item_kq` VALUES ('411','������','3','1','9','1329840000','4','��ȥ����','','','','','');
REPLACE INTO `p8_forms_item_kq` VALUES ('415','�����ݼ�','4','1','2','1329235200','9','��ŭ캿�','123456','','','','');
REPLACE INTO `p8_forms_item_mimaxiugai` VALUES ('279','����','it','2','123','123','����');
REPLACE INTO `p8_forms_item_mimaxiugai` VALUES ('280','����','it','1','123','123','����');
REPLACE INTO `p8_forms_item_mimaxiugai` VALUES ('401','fd','fdf','1','','123456','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('11','������','2011-1-25','1','���鰲��','2','��鿴��������','1','7','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('12','�������������ȫ������ֻ�����','2011-1-26','16','������','2','��鿴��������','2','4','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('13','�����ࡢ�Ŷ���������ȫ����ѩ����','2011-1-14','10','�¶Ȳ������','2','��鿴��������','1','2','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('95','������','2011-4-20','1','˹�ٷ�����','1','��鿴��������','1','1','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('96','�Ź�΢','2011-5-1','3','�ƶ��ɹ��ƻ�','2','��鿴��������','2','3','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('97','������','2011-3-20','8','�ֿ�����','1','��鿴��������','1','3','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('98','����','2011-4-1','6','ͳ���ۺ�����','1','��鿴��������','1','1','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('99','�ޱ�ѫ','2011-3-12','5','�����ߵ���','1','��鿴��������','3','3','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('100','���в�','2011-4-1','2','�����������ܽ�','2','��鿴��������','1','5','','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('101','��С��','2011-4-1','1','�����ܽ���','2','��鿴��������','3','6','http://','1302537600','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('102','�ܿ�','2011-3-2','4','G168��Ŀ','1','��鿴��������','1','7','http://','1302624000','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('103','����','2010-3-19','7','G108���β�Ʒ����','2','��鿴��������','1','3','http://','1297785600','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('104','��С��','2010-3-12','13','����ۺ��ɳ�','1','��Ҫ����������','1','4','http://','1308931200','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('124','������','9��4��14��00--5��19��00','4','��ɨ�������������һ��','1','��ɨ����','2','3','http://','1307548800','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('147','��С����������','9��4��14��00--5��19��00','1','��ҵ����ֵ��','2','��С��������ҡ��������Ÿ�ֵ��','2','4','http://','1307289600','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('158','2342342423','5��06��17��30--23��00 ','15','���鲼��','3','12121','2','2','http://www.php168.net','1308153600','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('167','34534534','345345','4','345435','3','345345345','345435','2','345345','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('346','34534534','345345','4','345435','3','345345345','345435','2','http://345345','','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('348','��С����������','9��4��14��00--5��19��00','1','��ҵ����ֵ��','2','��С��������ҡ��������Ÿ�ֵ��','2','4','http://','1307289600','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('349','������','9��4��14��00--5��19��00','4','��ɨ�������������һ��','1','��ɨ����','2','3','http://','1307548800','','');
REPLACE INTO `p8_forms_item_paiban` VALUES ('350','��С��','2010-3-12','13','����ۺ��ɳ�','1','��Ҫ����������','1','4','http://','1308931200','Z12021501','');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('7','30','����','1','','8��18','���','','','15','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('8','18','����','1','����','8��18��19����','���ط��Ĵ�','7��20��','˹�ٷ�����','15','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('15','20','����','1','','8��18��19','������ѵ','','','14','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('48','28','����Ÿ','6','','8��18��19','ִ�����������ѵ����','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('49','26','�Ŷ���','2','','3��18��19���Ͼ���','���������Ա������ѵ����','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('50','28','','1','������','','','3�·����Ͼ��ɣ�����ĩ','��ѧԱ�����������','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('51','14','������','2','','3��18��19����','ϣ���õ��������','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('52','10','','9','������','','','3��20��22����','��ѧԱ�������γ�','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('57','20','','8','���ǻ�','','','3��20��22���Ͼ���','���뱨����ϣ�����Եõ�֧��','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('58','24','������','1','','3�·ݾ���','���ܹ�˾��ȫ��ѵӦ��','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('68','16','�ܺ���','9','','3�·��°����','��Ҫ������������������֪ʶ','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('69','12','������','13','','3��18��19���Ͼ���','ϣ���õ�ѧϰ�̵����ϵĻ���','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('70','22','�ⳤ��','3','','3��18��19','�᰸�ļ�����鴦��','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('71','27','������','8','','3��18��19���Ͼ���','ѧ���΢��������','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('72','30','','4','������','','','3��20��22���Ͼ���','��ѧԱ�����᰸���','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('73','27','','12','���ǻ�','','','3��20��22���Ͼ���','ѧϰ��Ϣ��','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('74','14','','2','������','','','3��20��22���Ͼ���','����','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('75','6','','6','���ǻ�','','','3��20��22���Ͼ���','123213','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('76','24','','2','����Զ','','','3��20��22���Ͼ���','�ڿ�','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('77','18','','3','��ΰ','','','3��20��22���Ͼ���','�ڿ�','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('78','26','','1','��Т��','','','3��20��22���Ͼ���','�ڿο���','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('79','22','','8','������','','','3��20��22���Ͼ���','�ڿο���','13','3','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('80','12','������','13','','3��18��19���Ͼ���','ѧϰ������','','','13','4','10');
REPLACE INTO `p8_forms_item_peixinbaoming` VALUES ('410','12','','2','','','','','','13','4','10');
REPLACE INTO `p8_forms_item_peixunfangang` VALUES ('433','fdsaf','dfsafdasfdsafdsfewrtewdgfdsfewr4erfdsfvcxzvsf','fdsaf','','');
REPLACE INTO `p8_forms_item_peixunfangang` VALUES ('434','fadsf','dsafdasfdwrewfdsafdsaf','dasfdsaf','','');
REPLACE INTO `p8_forms_item_peixunfangang` VALUES ('443','����','������������������������������','15014799789','��','test@test.com');
REPLACE INTO `p8_forms_item_peixunfangang` VALUES ('444','343242342342','23432','23423','��','23423');
REPLACE INTO `p8_forms_item_peixunfangang` VALUES ('446','23423','23423','234324','��','23432');
REPLACE INTO `p8_forms_item_recruitment` VALUES ('447','����','1','24','����','15111098204','ë���̴�ѧ','���','5','php','php','');
REPLACE INTO `p8_forms_item_shengchan` VALUES ('119','·����','C002','2','2','5000PCS','1300291200','���ƽ','H20110328','1','�����������ϸ��Ϣ��','','Сë');
REPLACE INTO `p8_forms_item_shengchan` VALUES ('122','���г�','N2564','3','2','5000PCS','1301500800','ëС��','C200356894','2','3242323423234','','Сë');
REPLACE INTO `p8_forms_item_shengchan` VALUES ('360','3123','312','1','2','12321','1310313600','12321','12312312','2','12312','','123213');
REPLACE INTO `p8_forms_item_shengchan` VALUES ('361','123123','3123123','2','2','12312','1310400000','2312','12312','2','','�½� Microsoft Word �ĵ�.doc<!--#p8_attach#-->/core/forms/2011_07/11_12/e7f2877f09f80c1b.doc','12312');
REPLACE INTO `p8_forms_item_shoh` VALUES ('428','��С��','1','���ı󣬸����ڣ��Ĵ��ƾ�ְҵѧԺ���������Ľ��������Ρ����С�Ӧ����д�����͡���������ѧ��������Ҫ���ڡ�Ӧ����д������������ϵѧ���͡���������ѧ����\r\n��Ҫ���гɹ���\r\n1��2005��μӸߵȽ��������硰�е�ְҵѧУ�Ļ������Ρ������ġ���һ�������Ԫ�ı�д��\r\n2��2005����2006���������Ƹ�ְ����ϵ�н̲ĸ����࣬��һ�ֲ�̲ġ���ѧ�ο��顢��ý��μ����ֽű���ͬ����ϰ�����ࣻͬʱ���α�ڶ�����嵥Ԫ�̲ġ���ѧ�ο��顢��ý��μ����ֽű���ͬ����ϰ�᣻�����������Ԫ��ѧ�ο��顢�����ᡶ�ƾ�Ӧ���ġ��������鼰','','15989523698/020-8726356','ewrereewr@163.com','2','����');
REPLACE INTO `p8_forms_item_tiang` VALUES ('3','23423','234','1','1','1','23423','23423','23423','23422342323423','234233','','','','','','','0','','','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('4','Фͬ��','','1','1','1','Ф����','�ṩ��������','ϵͳ����ṩ��������','Dormy.png<!--#p8_attach#-->/core/forms/2011_02/14_18/a74eee8657b79b50.png.cthumb.jpg<!--#p8_attach#-->/core/forms/2011_02/14_18/a74eee8657b79b50.png.thumb.jpg','�ṩ��������','','','','','','','0','','','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('5','����','','2','2','2','����','����������','���������ˣ�����������','Dormy.png<!--#p8_attach#-->/core/forms/2011_02/14_18/a74eee8657b79b50.png.cthumb.jpg<!--#p8_attach#-->/core/forms/2011_02/14_18/a74eee8657b79b50.png.thumb.jpg','��������','','','','','','','0','','','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('105','��С��','','3','2','1','����','G108��Ŀ�Ŀ��������Ż�','��ԭ���Ĵ�ֱ�������̿����Ż�Ϊ���ο������̣������������ͬʱ���С�','','����������Ŀ���з�ʱ�䣬��ʡ��Ŀ���á�','1300636800','1','5','������','4','','0','1305734400','T1125191223','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('26','��С��','','1','2','3','����','�ɹ���������Ż�����','���ڵı�Ų��Ǻܺü�����ռ���&lt;br /&gt;\r\n&lt;br /&gt;\r\n�����Ϊ��˾��д+��+��+��+�����','�����ĵ������ĵ�','�������˺�ͬ�������Ķ��ԡ�','1294156800','1','4','������','1','','0','','T1125191256','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('27','������','','2','1','1','����','��������������','���ڵĴ����̵����ϲ��ҡ�ͳ�ơ����ϱ仯û�������������ƽ̨���ܷ���Ϣ��','1221','���ϱ�׼��','1296576000','1','5','������','2','','200','1305734400','T1125191225','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('28','����','','4','2','1','������','�з��������������Ż�','���ڵ��з������������̹��ڸ��ӣ������Ż���','121212','���Դ����ʡʱ��','1298908800','1','5','������','3','','0','1305734400','T1125191240','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('29','����','','6','1','3','����','����ѡ���빺�򷽰�','����ͬ�·�Ӧ���� ��ͨ�������Ų�Ϊ�����������⡣','','','1297180800','1','5','������','2','werwe','0','1305734400','T1105261235','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('30','������','','2','2','1','������','���۲������û�Э������','����������Ŀͻ���Դ������˫��˽��Э�̣�ϣ����˾��һ��ָ��˼��','','','1294070400','1','5','������','4','','0','1305734400','T1105251235','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('31','������','','2','2','3','������','���ڹ�˾����������ʵʩ','����̫�࣬���ʵʩ���࣬������������Ӧ����Ա������˾�ķ�����������','','','1299513600','1','5','������','2','','50','1305734400','T1125191260','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('32','������','','1','1','3','����','��ҵ��Ϣ��ʵʩ�뷽��','��ҵ����������Ҫ������Ϣ������','','','1299600000','1','5','������','2','','1000','1305734400','T1125191246','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('33','����','','1','1','3','����','��ҵ���󴰿ڹ�˾��վ�ĸ���','��ҵ���󴰿ڹ�˾��վ�ĸ�����ֱ�ӹ�ϵ����˾��ҵ����������','','','1299600000','1','5','������','2','','200','1305734400','T1125191245','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('106','������','','8','1','2','���','��Ʒ�洢�ֿ����ķ���','ͨ���Գ�Ʒ�洢�ֿ�����Ŀ��Լ��ٳ�Ʒ�洢ʱ����Ҫ����','','ͨ���Գ�Ʒ�洢�ֿ�����Ŀ��Լ��ٳ�Ʒ�洢ʱ����Ҫ����','1300636800','1','5','���������Ϊ�����','3','ʿ���ʿ���','100','1305734400','T1125191240','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('107','����','','3','2','1','�ܿ�','MSC�Ĺ���ƽ̨���ȶ�����','MSC�Ĺ���ƽ̨���ȶ����⣬���²��ܽ����ճ��Ĺ���','','','1300550400','1','5','ʿ�������������ͯ','3','�ķ��󷽷�������','100','1305734400','T1125191239','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('108','����','','2','2','2','�ŷ�','��˾Ӫҵ��װ�޷���','��������Ԥ�㡢��Ʒ�����װ�޲��ϡ�ʩ������','','','1300896000','1','5','Ϊ��λ�����','2','Ϊ��λ������������','4000','1305734400','T1125191237','','');
REPLACE INTO `p8_forms_item_tiang` VALUES ('169','45455','454','3','1','3','454','45645','456464','','45465','1305648000','','','','','','0','','','','');
REPLACE INTO `p8_forms_item_tuiliaopingt` VALUES ('120','���','1','C102125689','N12456898','������ū','��첻�����','������','����ͨ','','��ʱ��','','��Сë','1301500800','2');
REPLACE INTO `p8_forms_item_tuiliaopingt` VALUES ('121','40ŷ��������','2','N20258964','N56023548','�������','��������','������','����ͨ','','��ʱ��','','��Сë','1301500800','1');
REPLACE INTO `p8_forms_item_tuiliaopingt` VALUES ('131','��ʾ��','1','02030509','S020315','�������','��ѹ��','���ܳ�','������','','1212','','�Ŷ���','1303488000','1');
REPLACE INTO `p8_forms_item_tuiliaopingt` VALUES ('364','2324332','2','34234','23432','423432','2342342','234234','324234','','','','234324','1311004800','2');
REPLACE INTO `p8_forms_item_vijiaoshou` VALUES ('439','20101139550924446.jpg<!--#p8_attach#-->/core/forms/2014_11/10_13/537410ade772e9ae.jpg<!--#p8_attach#-->/core/forms/2014_11/10_13/537410ade772e9ae.jpg.thumb.jpg','<p>\r\n	ѧ�����������<br />\r\n	2003.9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��&nbsp;�μӵ�1���е�Ⱥ�۹��ʻ���<br />\r\n	2006.9-2007.1:&nbsp;������ѧ��ѧ��ѧѧԺ����ѧ��<br />\r\n	2008.2-2008.6:&nbsp;�Ϻ�������ѧ������ѵ����������ѵ<br />\r\n	2008.9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;�μӵ�4����','chenga9762002@aliyun.com','����ʦ','��������������:&nbsp;<br />\r\n1996.9-2000.6:&nbsp;�Ͷ��ڻ���ʦ����ѧ��ѧϵ��ѧ����רҵ<br />\r\n2000.9-2005.6:&nbsp;�Ͷ����人��ѧ��ѧͳ��ѧԺ,&nbsp;2005.6ȡ����ѧ��ʿѧλ<br />\r\n2005.7-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;�ڻ���ʦ����ѧ��ѧ��ͳ��ѧѧԺ����','���Ž�ѧ¥ 405','������ ����Ⱥ�ı�ʾ�� ');
REPLACE INTO `p8_forms_item_wjsg` VALUES ('420','23423','2','23423424234','23432424','23423','2','2','1330531200','','','');
REPLACE INTO `p8_forms_item_wjsg` VALUES ('421','345','2','34534','345','','1','1','1330531200','','','');
REPLACE INTO `p8_forms_item_wjsg` VALUES ('422','34534','1','34534','345','','1','2','1330531200','','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('272','������ ','1','23423','2342342','23424234','23423','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('340','234234234','2','2342342','234232','23423423234','','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('341','3333333','3','333','333','333333','33','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('342','23423','4','2342343','234234','23423423234','234324','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('352','23232423','3','23432','2343242','23423423','','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('373','2343242','2','23423424','234234','23423423432432','','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('375','23424','3','23423','23423','23432','','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('413','chang','2','234234','234234','23423423423432','234234','','');
REPLACE INTO `p8_forms_item_workbaom` VALUES ('414','324234','2','','23432','2343243243','3242','','');
REPLACE INTO `p8_forms_item_wuliu` VALUES ('111','ͨѶ�ֻ�/�豸','C20110319','2','�ֻ�1000����ͨѶ�豸50��','�����������Ϫ�ڽ����������Ĵ���201','������');
REPLACE INTO `p8_forms_item_wuliu` VALUES ('112','������','N2564895','1','������10̨','�����Ϸ�����208','�о�');
REPLACE INTO `p8_forms_item_wyh` VALUES ('250','������','6','1','������ɹ��̰���������̸����IC5806�۸������40Ԫ/pcs��������ɹ��۸��5ë/Pcs��\r\n\r\n\r\n','','�ɹ�������ʦ','2','6','1307462400','IC5806�ɹ��۸񽵵�5ë/PCS','Ԥ��1��󣬿��Խ���Լ�ɱ�3������\r\n\r\n\r\n');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('168','1213213121','2','5','4546554','1216545465','500','4654456454','1305129600','','','1','2','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('144','��Сޱ','4','100','PS20110406','������һ�ع�����','20000','��΢��������1�ף�������ѵ','1301760000','��ͬword�ı�.rar<!--#p8_attach#-->/core/forms/2011_03/15_17/f20defc3fed27d8a.rar','','1','1','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('145','���ΰ','4','100','PA20110406','�Ͼ�׿Խ�Ƽ����޹�˾','0','�Ͼ�������΢����Ȩ','1302624000','','','4','2','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('146','���� ','6','100','PV20110406','���ϴ�������','0','�������ϴ�������Ϊ��˾��Ӧ�̡�','1301760000','','','3','1','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('271','ζ��','2','100','34232','2342342','423423423','423423423423342','1306512000','','234','1','1','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('345','23423','6','100','3423423','ʿ���','23423','23423423423','315849600','','','2','1','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('369','2342342','3','5','23424','23423','23423','23423423','1310313600','','','2','1','');
REPLACE INTO `p8_forms_item_xiaoshougongzhang` VALUES ('404','������͵ķ�','3','100','��set��','ɶ�ط�','1111','11111','1323705600','','','1','1','');
REPLACE INTO `p8_forms_item_xinxidian` VALUES ('208','��С��','1','1','1305820800','1','���ݹ�΢����Ƽ����޹�˾','������','020-38907975','������','2','1','1','1','','');
REPLACE INTO `p8_forms_item_xinxidian` VALUES ('209','��С��','1','5','1305820800','2','���ݹ�΢����Ƽ����޹�˾','������','020-29865986/1569865986','����','2','1','2','1','','');
REPLACE INTO `p8_forms_item_xinxidian` VALUES ('351','345345','2','3','1310227200','2','34534523','23452345','34543454','32453454','3','1','1','1','345345345345345435','1');
REPLACE INTO `p8_forms_item_xinxidian` VALUES ('357','2343242','2','2','1310313600','1','23432','23423','23432','23423','1','1','1','1','23423','1');
REPLACE INTO `p8_forms_item_yanfapingtai` VALUES ('113','40V��ѹ��','C123456','2','40V����ȫ�Ըߣ�10A����','��С��','1','�ſ���','1','5.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/240d3c9932a9eae6.jpg<!--#p8_r_attach1#-->/core/forms/2011_03/15_17/240d3c9932a9eae6.jpg.thumb.jpg','','','','1');
REPLACE INTO `p8_forms_item_yuyue` VALUES ('448','4','23423432','1','234232','1','23423423','23423','2342343');
REPLACE INTO `p8_forms_item_zhuanan2` VALUES ('276','12312','2','1','12312321321232','1231232131','','');
REPLACE INTO `p8_forms_item_zppt` VALUES ('442','��Ϣϵͳ����Ա','5','����ά����','����','3','��ɳ','1','23������','1.ר�Ƽ�����ѧ�������ԣ�����������רҵ�������������������������\r\n2.������ʹ��һ�ֻ����ֿ������ԣ������������Ŀ�����ʵʩ�����ȣ�\r\n3.��Ϥ����������̣�����������Ӧ�̽��и���Ϣϵͳ��Ŀ��ȫ�̸��٣�\r\n4.�нϺõĹ�ͨ������Э��������ִ������������ǿ�������õ��Ŷ�Э������','1. ������ݹ�˾��Ϣ���滮����������Ϣ��ϵͳʵʩ������ϵͳ������滮��ϵͳʵʩ��ϵͳ����ά���ȣ�������Ϣϵͳ���������У�����ϵͳ�г��ֵ����⼰ʱ���Դ���\r\n2. �����ƶ����޶�ϵͳ���еĹ����ƶȣ����Ƹ���Ϣϵͳ���ƶ��ļ���\r\n3. ��������쵼���ŵ���ʱ������','');
REPLACE INTO `p8_forms_item_zppt` VALUES ('445','php','2','������Ӫ��','��ר����','1','��ɳ','1','20','�������渺��','�������渺��','');
REPLACE INTO `p8_forms_model` VALUES ('77','recruitment','��ҪӦƸ','1','','0','1','245','post_yingpin','list_yingpin','view_yingpin','a:0:{}');
REPLACE INTO `p8_forms_model` VALUES ('78','zppt','��Ƹƽ̨','1','','0','2','250','post_2017','list_supplier2017','view_print_2017','a:2:{s:7:\"captcha\";s:1:\"1\";s:8:\"viewself\";s:1:\"1\";}');
REPLACE INTO `p8_forms_model` VALUES ('16','banshi','���̲�ѯƽ̨','1','9','0','45','249','','list_supplier3c','view_print','a:1:{s:6:\"status\";a:2:{i:1;s:6:\"�Ѵ���\";i:2;s:6:\"������\";}}');
REPLACE INTO `p8_forms_model` VALUES ('4','peixunfangang','Ͷ�߽���','1','','0','5','253','post_tousujianyi','list_supplier3','view_print2','a:2:{s:6:\"status\";a:1:{i:1;s:9:\"�Ѵ���\";}s:8:\"viewself\";s:1:\"1\";}');
REPLACE INTO `p8_forms_model` VALUES ('27','bybd2','���õ绰','1','','0','4','245','','list_supplier3c','view_print','a:1:{s:7:\"captcha\";s:1:\"1\";}');
REPLACE INTO `p8_forms_model` VALUES ('47','zhuanan2','ר�������������ռ�','1','','0','1','0','','list_status2','view_print','a:1:{s:8:\"viewself\";s:1:\"1\";}');
REPLACE INTO `p8_forms_model` VALUES ('69','bybd6','��ѯƽ̨','1','','0','0','240','','list_luqu3','view_luqujieguo','a:0:{}');
REPLACE INTO `p8_forms_model` VALUES ('79','yuyue','����ԤԼ','1','','0','1','255','post_yuyue','list_supplier2018','view_yueyue','a:0:{}');
REPLACE INTO `p8_forms_model_field` VALUES ('83','dails','0','dlsxm','����������','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','70','','','','','�������������ҵ����');
REPLACE INTO `p8_forms_model_field` VALUES ('121','dlsdd','0','cwqrdz','����ȷ�ϵ���','varchar','14003-1','0','1','0','0','255','0','1','0','','a:3:{i:1;s:8:\"��δ����\";i:2;s:8:\"�Ѿ�����\";i:3;s:8:\"����״̬\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','0','','','','','��ȷ�ϴ������ύ�Ŀ���״̬�Ƿ��Ѿ�����');
REPLACE INTO `p8_forms_model_field` VALUES ('195','banshi','0','bianhao','���̱��','varchar','','1','1','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','style=\"width:85px;border:1px soild #ff0000\"','98','','','','','����������̵ı�ţ�û�����һ����L***,��L001');
REPLACE INTO `p8_forms_model_field` VALUES ('185','banshi','0','bslb','�������','varchar','','1','0','0','1','255','0','1','0','','a:4:{i:1;s:10:\"����ҵ����\";i:2;s:10:\"����������\";i:3;s:10:\"����������\";i:4;s:4:\"����\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','96','','','','','��ѡ��ð������');
REPLACE INTO `p8_forms_model_field` VALUES ('192','banshi','0','czsm','���̲���˵��','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:0:{}','textarea','cols=\"70\" rows=\"10\"','82','','','','','������ð��µľ�������˵��');
REPLACE INTO `p8_forms_model_field` VALUES ('193','banshi','0','fujian','��������','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','uploader','','80','','','','','�ð������и���˵�������ϴ�');
REPLACE INTO `p8_forms_model_field` VALUES ('194','banshi','0','lianj','���ӵ�ַ','varchar','','0','0','0','0','255','0','1','0','','a:1:{s:6:\"target\";s:6:\"_blank\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','link','size=\"70\"','78','','','','','ѡ����������ַ��ϸ˵��������д');
REPLACE INTO `p8_forms_model_field` VALUES ('187','banshi','0','lxr','������','varchar','','1','0','0','1','255','0','1','0','','a:0:{}','a:0:{}','text','','92','','','','','��������������ϵ�˻��������Ӧ��λ');
REPLACE INTO `p8_forms_model_field` VALUES ('184','banshi','0','name','��������','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','100','','','','#111','�����������������');
REPLACE INTO `p8_forms_model_field` VALUES ('538','banshi','0','sybumen','ʹ�ò���','varchar','','1','1','0','1','255','0','1','0','','a:6:{i:1;s:8:\"��������\";i:3;s:8:\"��������\";i:4;s:8:\"�о�����\";i:5;s:8:\"��ʿ����\";i:6;s:8:\"ѧԺ��ʦ\";i:7;s:8:\"��������\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','95','','','','','��ѡ������̿��ܻ�ʹ�õĲ���');
REPLACE INTO `p8_forms_model_field` VALUES ('188','banshi','0','tel','�绰/�ֻ�','varchar','','1','0','0','1','255','0','1','0','','a:0:{}','a:0:{}','text','','90','','','','','���������ϵ�˵绰');
REPLACE INTO `p8_forms_model_field` VALUES ('25','peixunfangang','0','name','����','varchar','','1','1','0','1','255','0','1','0','','a:1:{s:6:\"target\";s:5:\"_self\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','60','','','','','��������������');
REPLACE INTO `p8_forms_model_field` VALUES ('861','yuyue','0','city','���ڳ���','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('702','peixunfangang','0','tel','�ƶ��绰','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','58','','','','','����д������ϵ��ʽ���������');
REPLACE INTO `p8_forms_model_field` VALUES ('27','peixunfangang','0','neirong','��ϸ����','varchar','','0','0','0','1','255','0','1','0','','a:1:{s:6:\"target\";s:5:\"_self\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"70\" rows=\"10\"','10','','','','','������ϸ����');
REPLACE INTO `p8_forms_model_field` VALUES ('862','yuyue','0','purchase','�ɹ�����','varchar','','0','0','0','1','255','0','1','0','1','a:2:{i:1;s:6:\"����\";i:2;s:6:\"��˾\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','radio','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('836','zppt','0','name','��Ƹְλ','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','����д��������');
REPLACE INTO `p8_forms_model_field` VALUES ('837','zppt','0','number','��Ƹ����','varchar','','1','1','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','��','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('838','zppt','0','bumen','��Ƹ����','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('839','zppt','0','xueli','ѧ��Ҫ��','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('840','zppt','0','gongzuo','��������','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','��','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('841','zppt','0','gzdd','�����ص�','varchar','','1','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('842','zppt','0','sex','�Ա�','varchar','','0','0','0','1','255','0','1','0','','a:3:{i:1;s:2:\"��\";i:2;s:2:\"Ů\";i:3;s:4:\"����\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('843','zppt','0','age','����Ҫ��','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','size=\"38\"','0','','','','','����д������������');
REPLACE INTO `p8_forms_model_field` VALUES ('844','zppt','0','gwyq','��λҪ��','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"70\" rows=\"10\"','0','','','','','����д�������');
REPLACE INTO `p8_forms_model_field` VALUES ('845','zppt','0','gwzz','��λְ��','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"70\" rows=\"10\"','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('846','zppt','0','fujian','����','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','uploader','','0','','','','','���и������ϴ�');
REPLACE INTO `p8_forms_model_field` VALUES ('847','recruitment','0','name','����','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','35','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('848','recruitment','0','xingbie','�Ա�','varchar','','0','0','0','1','255','0','1','0','1','a:2:{i:1;s:3:\"��\";i:2;s:3:\"Ů\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','radio','','33','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('849','recruitment','0','lianling','����','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','31','','','','','��');
REPLACE INTO `p8_forms_model_field` VALUES ('850','recruitment','0','jiguan','����','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','28','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('851','recruitment','0','tel','��ϵ�绰','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','26','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('852','recruitment','0','xuexiao','��ҵѧУ','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','24','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('853','recruitment','0','zhuanye','��ѧרҵ','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','21','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('854','recruitment','0','xueli','ѧ��','varchar','','0','0','0','1','255','0','1','0','','a:5:{i:1;s:4:\"��ʿ\";i:2;s:4:\"˶ʿ\";i:3;s:4:\"����\";i:4;s:4:\"ר��\";i:5;s:4:\"����\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','18','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('855','recruitment','0','ganwei','ӦƸ��λ','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','16','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('856','recruitment','0','xiangqing','��ϸ˵��','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"100\" rows=\"20\"','12','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('857','recruitment','0','fujian','�����ĵ�','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','uploader','','10','','','','','���и����ĵ����ϴ�');
REPLACE INTO `p8_forms_model_field` VALUES ('334','banshi','0','tupian','ͼƬ˵��','text','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','multi_uploader','size=\"2\"','81','','','','','����ͼƬ˵�����ϴ�');
REPLACE INTO `p8_forms_model_field` VALUES ('438','bybd2','0','mingcheng','��λ����','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','��������ϵ��λ����');
REPLACE INTO `p8_forms_model_field` VALUES ('439','bybd2','0','lxr','��ϵ��','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','��������ϵ������');
REPLACE INTO `p8_forms_model_field` VALUES ('440','bybd2','0','leixing','��λ����','varchar','','1','1','0','1','255','0','1','0','','a:13:{i:13;s:12:\"��ҵ�ڲ��绰\";i:1;s:8:\"��ݹ�˾\";i:2;s:8:\"��ˮ��˾\";i:3;s:8:\"�Ͳ͵���\";i:4;s:8:\"���乫˾\";i:5;s:8:\"��ҹ�˾\";i:6;s:8:\"��Ƹ����\";i:7;s:8:\"��������\";i:8;s:6:\"С����\";i:9;s:8:\"���ι�˾\";i:10;s:8:\"�����绰\";i:11;s:8:\"ҽԺ����\";i:12;s:4:\"����\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','0','','','','','��ѡ��õ�λ��������');
REPLACE INTO `p8_forms_model_field` VALUES ('441','bybd2','0','tel','�绰/�ֻ�','varchar','','1','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','��������ϵ�˵绰���ֻ�����');
REPLACE INTO `p8_forms_model_field` VALUES ('442','bybd2','0','fax','�������','varchar','','1','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','��������ϵ�˴������');
REPLACE INTO `p8_forms_model_field` VALUES ('443','bybd2','0','email','����','varchar','','1','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','��������ϵ������');
REPLACE INTO `p8_forms_model_field` VALUES ('444','bybd2','0','QQ','QQ/MSN','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','��������ϵ��QQ/MSN����');
REPLACE INTO `p8_forms_model_field` VALUES ('445','bybd2','0','dizhi','�����ַ','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','size=\"38\"','0','','','','','��������ϵ��λ�����ַ');
REPLACE INTO `p8_forms_model_field` VALUES ('446','bybd2','0','wangzhi','��ַ','varchar','','0','0','0','0','255','0','1','0','','a:1:{s:6:\"target\";s:6:\"_blank\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','link','','0','','','','','��������ϵ��λ�ľ�����ַ');
REPLACE INTO `p8_forms_model_field` VALUES ('447','bybd2','0','beizhu','��ע˵��','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"70\" rows=\"6\"','0','','','','','�绹����ر�ע��������');
REPLACE INTO `p8_forms_model_field` VALUES ('860','yuyue','0','province','����ʡ��','varchar','','0','0','0','0','255','0','1','0','','a:34:{i:1;s:6:\"����\";i:2;s:6:\"�Ϻ�\";i:3;s:6:\"���\";i:4;s:6:\"����\";i:5;s:6:\"�Ĵ�\";i:6;s:6:\"����\";i:7;s:6:\"����\";i:8;s:6:\"����\";i:9;s:6:\"����\";i:10;s:6:\"����\";i:11;s:6:\"����\";i:12;s:6:\"�㶫\";i:13;s:6:\"����\";i:14;s:6:\"����\";i:15;s:6:\"����\";i:16;s:6:\"�ຣ\";i:17;s:6:\"����\";i:18;s:6:\"�½�\";i:19;s:6:\"�ӱ�\";i:20;s:6:\"ɽ��\";i:21;s:9:\"���ɹ�\";i:22;s:6:\"����\";i:23;s:6:\"�㽭\";i:24;s:6:\"����\";i:25;s:6:\"����\";i:26;s:6:\"����\";i:27;s:6:\"ɽ��\";i:28;s:6:\"����\";i:29;s:6:\"����\";i:30;s:9:\"������\";i:31;s:6:\"����\";i:32;s:6:\"̨��\";i:33;s:6:\"���\";i:34;s:6:\"����\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','class=\"set\"','100','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('580','zhuanan2','0','tibaoren','�ᱨ��','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','30','','','','','����д�ᱨ������');
REPLACE INTO `p8_forms_model_field` VALUES ('581','zhuanan2','0','bum','����','varchar','','1','1','0','1','255','0','1','0','','a:17:{i:1;s:10:\"��˾�쵼��\";i:2;s:6:\"������\";i:3;s:6:\"�з���\";i:4;s:6:\"���۲�\";i:5;s:6:\"�ۺ�\";i:6;s:6:\"�ɹ���\";i:7;s:6:\"������\";i:8;s:6:\"�Ƶ���\";i:9;s:6:\"�ʼ첿\";i:10;s:6:\"�ֹܲ�\";i:11;s:6:\"����\";i:12;s:10:\"������Դ��\";i:13;s:6:\"������\";i:14;s:6:\"���ڲ�\";i:15;s:6:\"���ز�\";i:16;s:6:\"���粿\";i:17;s:8:\"��������\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','28','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('582','zhuanan2','0','leixing','����','varchar','','1','1','0','1','255','0','1','0','','a:3:{i:1;s:8:\"ר������\";i:2;s:8:\"ר������\";i:3;s:4:\"����\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','26','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('583','zhuanan2','0','biaoti','����','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','size=\"50\"','22','','','','','���������ݵı���');
REPLACE INTO `p8_forms_model_field` VALUES ('584','zhuanan2','0','xiangqing','��������','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"90\" rows=\"14\"','20','','','','','����дר���������������');
REPLACE INTO `p8_forms_model_field` VALUES ('585','zhuanan2','0','fjian','��������','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','uploader','','0','','','','','���и������ϣ����ϴ���');
REPLACE INTO `p8_forms_model_field` VALUES ('593','zhuanan2','0','zycd','��Ҫ�̶�','varchar','','1','1','0','1','255','0','1','0','','a:4:{i:1;s:4:\"����\";i:2;s:4:\"��Ҫ\";i:3;s:6:\"����Ҫ\";i:4;s:4:\"����\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','24','','','','','��ѡ������ͽ��������õ���Ҫ������̶�');
REPLACE INTO `p8_forms_model_field` VALUES ('787','bybd6','0','baofei','¼ȡ״̬','varchar','','1','0','0','0','255','0','1','0','','a:4:{i:5;s:6:\"Ԥ¼ȡ\";i:4;s:4:\"¼ȡ\";i:3;s:8:\"û��¼ȡ\";i:2;s:4:\"����\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','42','','','','','������¼ȡ״̬');
REPLACE INTO `p8_forms_model_field` VALUES ('788','bybd6','0','beizhu','��ע','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','cols=\"70\" rows=\"6\"','40','','','','','���б�ע������д');
REPLACE INTO `p8_forms_model_field` VALUES ('789','bybd6','0','cplx','�Ա�','varchar','','0','0','0','1','255','0','1','0','','a:2:{i:1;s:2:\"��\";i:3;s:2:\"Ů\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','59','','','','','��ѡ���Ա�');
REPLACE INTO `p8_forms_model_field` VALUES ('790','bybd6','0','cpmc','����','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','style=\"width:205px;border:1px soild #ff0000\"','60','','','','','�����뿼������');
REPLACE INTO `p8_forms_model_field` VALUES ('791','bybd6','0','date','¼ȡ����','varchar','','1','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textdate','','48','','','','','��ѡ��¼ȡ����');
REPLACE INTO `p8_forms_model_field` VALUES ('792','bybd6','0','hgcp','�ʼĵ�ַ','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','44','','','','','�������ʼĵ�ַ');
REPLACE INTO `p8_forms_model_field` VALUES ('793','bybd6','0','nianfen','¼ȡרҵ','varchar','','0','0','0','1','255','0','1','0','','a:3:{i:1;s:12:\"������Ϣ����\";i:2;s:14:\"��������뼼��\";i:3;s:8:\"��ľ����\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','51','','','','','��ѡ��¼ȡרҵ');
REPLACE INTO `p8_forms_model_field` VALUES ('794','bybd6','0','sjsl','EMS���','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','46','','','','','�������ݱ��');
REPLACE INTO `p8_forms_model_field` VALUES ('795','bybd6','0','tibaoren','������','varchar','','1','1','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','style=\"width:205px;border:1px soild #ff0000\"','55','','','','','�����뿼����');
REPLACE INTO `p8_forms_model_field` VALUES ('796','bybd6','0','yuefen','���','varchar','','0','0','0','1','255','0','1','0','','a:4:{i:1;s:4:\"˶ʿ\";i:2;s:4:\"����\";i:3;s:4:\"ר��\";i:4;s:4:\"����\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','','50','','','','','��ѡ��¼ȡ���');
REPLACE INTO `p8_forms_model_field` VALUES ('858','peixunfangang','0','sex','�Ա�','varchar','','0','0','0','1','255','0','1','0','��','a:2:{s:3:\"��\";s:3:\"��\";s:3:\"Ů\";s:3:\"Ů\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','radio','','59','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('859','peixunfangang','0','email','�����ʼ�','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','30','','/^[w-.]+@[w-.]+(.w+)+$/','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('863','yuyue','0','name','��λ����','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('865','yuyue','0','select','��Ʒ����','varchar','','0','0','0','1','255','0','1','0','','a:3:{i:1;s:9:\"��Ʒһ\";i:2;s:9:\"��Ʒ��\";i:3;s:9:\"��Ʒ��\";}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','select','class=\"set\"','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('866','yuyue','0','phone','�ֻ�����','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('867','yuyue','0','mailbox','��ϵ����','varchar','','0','0','0','1','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','text','','0','','','','','');
REPLACE INTO `p8_forms_model_field` VALUES ('868','yuyue','0','content','��������','varchar','','0','0','0','0','255','0','1','0','','a:0:{}','a:1:{s:6:\"layout\";s:7:\"horizen\";}','textarea','','0','','','','','');
REPLACE INTO `p8_config` VALUES ('core','forms','string','htmlize','0');
REPLACE INTO `p8_config` VALUES ('core','forms','string','html_post_url_rule','{$module_url}/{$name}.html');
REPLACE INTO `p8_config` VALUES ('core','forms','string','dynamic_list_url_rule','{$module_controller}-list-mid-{$id}#-page-{$page}#.html');
REPLACE INTO `p8_config` VALUES ('core','forms','string','dynamic_view_url_rule','{$module_controller}-view-id-{$id}.html');
REPLACE INTO `p8_config` VALUES ('core','forms','string','html_list_url_rule','{$module_url}/list_{$id}#-page-{$page}#html');
REPLACE INTO `p8_config` VALUES ('core','forms','string','html_view_url_rule','{$module_url}/{$id}.html');
REPLACE INTO `p8_config` VALUES ('core','forms','serialize','status','a:4:{i:-1;s:4:\"�˷�\";i:0;s:6:\"δ����\";i:1;s:6:\"������\";i:9;s:6:\"������\";}');
REPLACE INTO `p8_config` VALUES ('core','forms','string','view_page_cache_ttl','0');