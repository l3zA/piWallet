call diff.bat
:loop
::%USERPROFILE%\Downloads\ccminer-818-cuda91-x64\ccminer -a neoscrypt -o stratum+tcp://pool1.phi-phi-pool.com:4233 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p c=BTC
::%USERPROFILE%\Downloads\ccminer-x64-2.2.4-cuda9\ccminer-x64 -a lyra2v2 -o stratum+tcp://pool1.phi-phi-pool.com:4533 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p c=BTC
::%USERPROFILE%\Downloads\ccminer-818-cuda91-x64\ccminer -a c11 -o stratum+tcp://pool1.phi-phi-pool.com:3573 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p c=BTC
::%USERPROFILE%\Downloads\ccminer-xevan\ccminer_x86.exe -a xevan -o stratum+tcp://s.umine.org:3739 -u ScPpvD2vgRB95b8VF2CXdN3RdxG9HpLBQH.%COMPUTERNAME% -p c=XLR
::%USERPROFILE%\Downloads\ccminer-x64-2.2.4-cuda9\ccminer-x64 -a nist5 -o stratum+tcp://pool.bsod.pw:3833 -u bNRVpP2b7jrYEw15wZbuuCZgeTNac1WXVD.%COMPUTERNAME% -p c=BWK
::%USERPROFILE%\Downloads\ccminer-818-cuda91-x64\ccminer -a neoscrypt  -o stratum+tcp://neoscrypt.mine.zergpool.com:4233 -u VDtoPYmCL7TMu9Au3sBbxfsYDxeQxRzKqS.%COMPUTERNAME%%MY_DIFF% -p c=VIVO,mc=VIVO
::%USERPROFILE%\Downloads\enemyminer1.03win\ccminer-x64 -a x16r -o stratum+tcp://ravenminer.com:3666 -u RWJ9PDbcpEG9UnC5ehGwK2vYZCxSwXnxxY.%COMPUTERNAME% -p c=RVN%MY_DIFF%
::%USERPROFILE%\Downloads\ccminer-x64-2.2.5-rvn-cuda9\ccminer-x64 -a x16r -o stratum+tcp://ravenminer.com:3666 -u RWJ9PDbcpEG9UnC5ehGwK2vYZCxSwXnxxY.%COMPUTERNAME% -p c=RVN%MY_DIFF%
::%USERPROFILE%\Downloads\enemyminer1.03win\ccminer-x64 -a x16r -o stratum+tcp://rvn.suprnova.cc:6667 -u l3za.%COMPUTERNAME% -p x%MY_DIFF%
::%USERPROFILE%\Downloads\z-enemy-1.05\z-enemy -a x16r -o stratum+tcp://rvn.suprnova.cc:6667 -u l3za.%COMPUTERNAME% -p x%MY_DIFF%
::%USERPROFILE%\Downloads\suprminer-1.6\ccminer -a x16r -o stratum+tcp://rvn.suprnova.cc:6667 -u l3za.%COMPUTERNAME% -p x%MY_DIFF%
::%USERPROFILE%\Downloads\ccminer-818-cuda91-x64\ccminer -a neoscrypt -o stratum+tcp://neoscrypt.mine.ahashpool.com:4233 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p c=BTC
::%USERPROFILE%\Downloads\PGNminer2.2.5AddAlgo\ccminer -a x16s -o stratum+tcp://pool1.phi-phi-pool.net:3637 -u PVg5iZzpyEKU4Ts1inkCAXt488CouRCiSM.%COMPUTERNAME% -p c=PGN
::%USERPROFILE%\Downloads\ccminer-x64-2.2.5-rvn-cuda9\ccminer-x64 -a hmq1725 -o stratum+tcp://hashfaster.com:3748 -u EhVpG3CYGMcuzVMSzJStnBRSCqxGFta17M.%COMPUTERNAME% -p c=ERA%MY_DIFF%
::%USERPROFILE%\Downloads\ccminer-x64-2.2.5-rvn-cuda9\ccminer-x64 -a phi1612 -o stratum+tcp://eu2.bsod.pw:6667 -u LPRpXFstdEH13wk6whmGXAK1vUrAgoXGQD.%COMPUTERNAME% -p c=LUX
::%USERPROFILE%\Downloads\ccminer-818-cuda91-x64\ccminer -a neoscrypt -o stratum+tcp://stratum.gos.cx:4242 -u GHsCiMoCiQUdLBeZix8EwNaFq1uvcr1Hbt.%COMPUTERNAME% -p c=SNC
::%USERPROFILE%\Downloads\ccminer2.3.0-allium\ccminer-x64 -a allium -o stratum+tcp://grlc.suprnova.cc:8600 -u l3za.%COMPUTERNAME% -p x
::%USERPROFILE%\Downloads\suprminer-1.6\ccminer -a neoscrypt -o stratum+tcp://eu1.arcpool.com:1121 -u BNBTy87LskJE4hKUGXEFyvQyF4dW9Z5CcJ.%COMPUTERNAME% -p c=BEPAY%MY_DIFF%

::%USERPROFILE%\Downloads\lux-sp-mod1\ccminer -a phi -o stratum+tcp://pool1.phi-phi-pool.com:8333 -u 3MJH6zFkwxhGYz2H8j59gYpCcnKAUjsJK7.%COMPUTERNAME% -p ID=%COMPUTERNAME%,c=BTC%MY_DIFF%

cd %USERPROFILE%\Downloads\Sniffdogminer-master
::startsniffin_phiphipool_Bitcoin.bat
startsniffin_Zergpool_Litecoin

::%USERPROFILE%\Downloads\suprminer-1.6\ccminer -a keccak -o stratum+tcp://asia-mine.smartcash.cc:3256 -u SRSQg6BzRzaQynKBv9y6shVKw9t2Xc7RTg.%COMPUTERNAME% -p x%MY_DIFF%

timeout /T 10
goto loop
