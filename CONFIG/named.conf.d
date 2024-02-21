options {
    listen-on port 53 { any; };
    directory       "/var/named";
    dump-file       "/var/named/data/cache_dump.db";
    statistics-file "/var/named/data/named_stats.txt";
    memstatistics-file "/var/named/data/named_mem_stats.txt";
    allow-query     { any; };
    recursion yes;
};

zone "${name}" {
    type master;
    file "/etc/named/zones/${name}.zone";
};
