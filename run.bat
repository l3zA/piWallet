:loop
::%USERPROFILE%\Downloads\ccminer-818-cuda91-x64\ccminer -a neoscrypt -o stratum+tcp://pool1.phi-phi-pool.com:4233 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p c=BTC
::%USERPROFILE%\Downloads\ccminer-x64-2.2.4-cuda9\ccminer-x64 -a lyra2v2 -o stratum+tcp://pool1.phi-phi-pool.com:4533 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p c=BTC
::%USERPROFILE%\Downloads\ccminer-818-cuda91-x64\ccminer -a c11 -o stratum+tcp://pool1.phi-phi-pool.com:3573 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p c=BTC
::%USERPROFILE%\Downloads\ccminer-xevan\ccminer_x86.exe -a xevan -o stratum+tcp://s.umine.org:3739 -u ScPpvD2vgRB95b8VF2CXdN3RdxG9HpLBQH.%COMPUTERNAME% -p c=XLR
::%USERPROFILE%\Downloads\ccminer-x64-2.2.4-cuda9\ccminer-x64 -a nist5 -o stratum+tcp://pool.bsod.pw:3833 -u bNRVpP2b7jrYEw15wZbuuCZgeTNac1WXVD.%COMPUTERNAME% -p c=BWK
::%USERPROFILE%\Downloads\ccminer-818-cuda91-x64\ccminer -a neoscrypt  -o stratum+tcp://eu1.fairmine.pro:4250 -u VDtoPYmCL7TMu9Au3sBbxfsYDxeQxRzKqS.%COMPUTERNAME% -d 1,2,3,4 -p c=VIVO
%USERPROFILE%\Downloads\ccminer-Enemy\ccminer -a x16r -o stratum+tcp://ravenminer.com:3666 -u RWJ9PDbcpEG9UnC5ehGwK2vYZCxSwXnxxY.%COMPUTERNAME% -d 1,2,3,4 -p c=RVN -i 17
timeout /T 10
goto loop
