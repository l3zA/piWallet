:loop
::%USERPROFILE%\Downloads\ccminer-818-cuda91-x64\ccminer -a neoscrypt -o stratum+tcp://pool1.phi-phi-pool.com:4233 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p c=BTC
::%USERPROFILE%\Downloads\ccminer-x64-2.2.4-cuda9\ccminer-x64 -a lyra2v2 -o stratum+tcp://pool1.phi-phi-pool.com:4533 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p c=BTC
::%USERPROFILE%\Downloads\ccminer-818-cuda91-x64\ccminer -a c11 -o stratum+tcp://pool1.phi-phi-pool.com:3573 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p c=BTC
%USERPROFILE%\Downloads\ccminer-xevan\ccminer_x86.exe -a xevan -o stratum+tcp://s.umine.org:3739 -u ScPpvD2vgRB95b8VF2CXdN3RdxG9HpLBQH.%COMPUTERNAME% -p c=XLR

timeout /T 10
goto loop
