# Merc

MERC , developed by Litmus7, enables customers to implement Redis cache integration with Magento-2. MERC provides options for customers to view and manage the Redis cache keys directly through the magento admin. With the help of this extension, customer can monitor the important Redis metrics, thus making sure the Redis cache management is working effectively. MERC provides an option for users to configure and connect Redis cache with magento. This extension collects all the required information from the user through a configuration form and this data is used to configure and connect Redis with Magento. If your Redis cache server is already configured with magento, then this MERC extension will automatically loads the configuration parameters and connects with the Redis cache. MERC makes sure the Redis cahce server is configured properly with the magento. After establishing the connection with Redis cache, the customers can view all the Redis metrics statistics including performance metrics, memory metrics, base activity metrics, persistence metrics and error metrics. Under the MERC - Keys section, the customers can view all the Redis cache keys and tags. MERC also allows customers to search cache keys,  bulk delete cache keys and also flush the entire Redis cached data. The customer can also delete a product specific cache keys through the product edit page. 

The performance metrics statistics, shows the parameters such as hit-rate, instantaneous operations per second, total net input, total net output, instantaneous input and instantaneous output. Among these, hit-rate is the ratio between key space hits with key space misses. Monitoring the hit-rate alerts the customer if the cache is being used effectively or not.  A low hit rate means that clients are looking for keys that no longer exist. Low hit rates could cause increases in the latency of your applications. Regarding the instantaneous operations per second, A drop in the number of commands processed per second as compared to historical norms could be a sign of either low command volume or slow commands blocking the system. Low command volume could be normal, or it could be indicative of problems upstream.

The memory metrics statistics, shows parameters such as used memory, memory fragmentation ratio, evicted keys, blocked clients etc. Memory fragmentation ratio is the  the ratio of memory used as seen by the operating system to memory allocated by Redis. Tracking fragmentation ratio is important for understanding your Redis instance’s performance. A fragmentation ratio greater than 1 indicates fragmentation is occurring. A ratio in excess of 1.5 indicates excessive fragmentation, with your Redis instance consuming 150% of the physical memory it requested. A fragmentation ratio below 1 tells you that Redis needs more memory than is available on your system. Tracking key eviction is important because Redis processes each operation sequentially, meaning that evicting a large number of keys can lead to lower hit rates and thus longer latency times. An increase in the number of blocked clients waiting on data could be a sign of
trouble. MERC helps to keep track of the number of blocked clients thus making sure, the server's performance is optimum. 

The base activity metrics, shows the parameters such as connected client, connected slaves and redis server uptime. If the number of connected clients leaves the normal range, this could indicate a problem. If it is too low, upstream connections may have been lost, and if it is too high, the large number of concurrent client connections could overwhelm your server’s ability to handle requests. Monitoring client connections helps you ensure you have enough free resources available for new clients or an administrative session. If the number of connected slaves change unexpectedly, it could indicate a down
host or problem with the slave instance. The persistence metrics, shows parameters such as RDB last save time and RDB changes since last save.

Version: 1.0.0

Requirements: Magento Community Edition version 2.0.2 or higher, Redis Server version 3.0 or higher

Features: 
	Automatic Redis configuration with Magento.
	Merchant can view all the Redis keys.
	Merchant can search for a specific Redis key.
	Functionality to flush all Redis keys.
	Merchant can delete any number of keys as per the choice.
	Merchant can monitor all the important Redis Metrics.
	Merchant can delete the Redis keys of specific products.
	
Installation: https://youtu.be/0ZyHuEZL3Qw

Configuration: https://youtu.be/gv1aH_cJHWs
