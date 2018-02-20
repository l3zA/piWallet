:loop
::%USERPROFILE%\Downloads\ccminer-818-cuda91-x64\ccminer -a neoscrypt -o stratum+tcp://pool1.phi-phi-pool.com:4233 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p c=BTC
%USERPROFILE%\Downloads\ccminer-x64-2.2.4-cuda9\ccminer-x64 -a lyra2v2 -o stratum+tcp://pool1.phi-phi-pool.com:4533 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p c=BTC
timeout /T 10
goto loop
