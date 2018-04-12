## <?php exit;?>
## main index {template}{
#################################################
#source #{index_name}#{
#	type					= mysql
#
#	sql_host				= #{db_host}#
#	sql_user				= #{db_user}#
#	sql_pass				= #{db_password}#
#	sql_db					= #{db_name}#
#	sql_port				= #{db_port}#
#	#sql_sock				= #{db_sock}#
#	
#	sql_query_pre = SET NAMES #{db_charset}#
#
##{sql_query_pre}#
#
##{sql_query}#
#
##{attributes}#
#	
##{sql_query_info}#
#}

#index #{index_name}#{
#	source				= #{index_name}#
#	path				= ../data/#{index_path}##{index_name}#
#	docinfo				= extern
#	#charset_type		= sbcs
#	charset_dictpath	= ../data/
#	charset_type		= zh_cn.#{charset}#
#}

#################################################
## main index {template}}


## delta index {template}{
#################################################
#source delta_#{index_name}# : #{index_name}#{
#
#	sql_query_pre = SET NAMES #{db_charset}#
#	
##{sql_query_post}#
#
##{sql_query}#
#}

#index delta_#{index_name}# : #{index_name}#{
#	source				= delta_#{index_name}#
#	path				= ../data/#{index_path}#delta_#{index_name}#
#}

#################################################
## delta index {template}}













### new index ###























#############################################################################
## indexer settings
#############################################################################

indexer
{
	# memory limit, in bytes, kiloytes (16384K) or megabytes (256M)
	# optional, default is 32M, max is 2047M, recommended is 256M to 1024M
	mem_limit			= 32M

	# maximum IO calls per second (for I/O throttling)
	# optional, default is 0 (unlimited)
	#
	# max_iops			= 40


	# maximum IO call size, bytes (for I/O throttling)
	# optional, default is 0 (unlimited)
	#
	# max_iosize		= 1048576
}

#############################################################################
## searchd settings
#############################################################################

searchd
{
	# hostname, port, or hostname:port, or /unix/socket/path to listen on
	# multi-value, multiple listen points are allowed
	# optional, default is 0.0.0.0:3312 (listen on all interfaces, port 3312)
	#
	# listen				= 127.0.0.1
	# listen				= 192.168.0.1:3312
	# listen				= 3312
	# listen				= /var/run/searchd.sock


	# log file, searchd run info is logged here
	# optional, default is 'searchd.log'
	log					= @CONFDIR@/log/searchd.log

	# query log file, all search queries are logged here
	# optional, default is empty (do not log queries)
	query_log			= @CONFDIR@/log/query.log

	# client read timeout, seconds
	# optional, default is 5
	read_timeout		= 5

	# request timeout, seconds
	# optional, default is 5 minutes
	client_timeout		= 300

	# maximum amount of children to fork (concurrent searches to run)
	# optional, default is 0 (unlimited)
	max_children		= 30

	# PID file, searchd process ID file name
	# mandatory
	pid_file			= searchd.pid

	# max amount of matches the daemon ever keeps in RAM, per-index
	# WARNING, THERE'S ALSO PER-QUERY LIMIT, SEE SetLimits() API CALL
	# default is 1000 (just like Google)
	max_matches			= 10000

	# seamless rotate, prevents rotate stalls if precaching huge datasets
	# optional, default is 1
	seamless_rotate		= 1

	# whether to forcibly preopen all indexes on startup
	# optional, default is 0 (do not preopen)
	preopen_indexes		= 0

	# whether to unlink .old index copies on succesful rotation.
	# optional, default is 1 (do unlink)
	unlink_old			= 1

	# attribute updates periodic flush timeout, seconds
	# updates will be automatically dumped to disk this frequently
	# optional, default is 0 (disable periodic flush)
	#
	# attr_flush_period	= 900


	# instance-wide ondisk_dict defaults (per-index value take precedence)
	# optional, default is 0 (precache all dictionaries in RAM)
	#
	# ondisk_dict_default	= 1


	# MVA updates pool size
	# shared between all instances of searchd, disables attr flushes!
	# optional, default size is 1M
	mva_updates_pool	= 1M

	# max allowed network packet size
	# limits both query packets from clients, and responses from agents
	# optional, default size is 8M
	max_packet_size		= 8M

	# crash log path
	# searchd will (try to) log crashed query to 'crash_log_path.PID' file
	# optional, default is empty (do not create crash logs)
	#
	# crash_log_path		= @CONFDIR@/log/crash


	# max allowed per-query filter count
	# optional, default is 256
	max_filters			= 256

	# max allowed per-filter values count
	# optional, default is 4096
	max_filter_values	= 4096
}

# --eof--