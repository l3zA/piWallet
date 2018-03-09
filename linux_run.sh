#!/usr/bin/env bash


# Load global settings settings.conf
if ! source ~/settings.conf; then
        echo "FAILURE: Can not load global settings 'settings.conf'"
        exit 9
fi

# Set power limit
sudo nvidia-smi -pm ENABLED
sudo nvidia-smi -pl "$MY_WATT"
echo

export GPU_FORCE_64BIT_PTR=0
export GPU_MAX_HEAP_SIZE=100
export GPU_USE_SYNC_OBJECTS=1
export GPU_MAX_ALLOC_PERCENT=100
export GPU_SINGLE_ALLOC_PERCENT=100

#
# ccminer Mining
#

#~/miner/klaust/ccminer/ccminer -a neoscrypt -o stratum+tcp://pool1.phi-phi-pool.com:4233 -u $MY_ADDRESS.$MY_RIG -p c=BTC $I_V
#~/miner/tpruvot/ccminer-run -a lyra2v2 -o stratum+tcp://stratum.gos.cx:4502 -u ATzJo4YWAbvReoCivZa5TUn1Psw6ndZvpG.$MY_RIG -p c=ABS
#~/miner/tpruvot/ccminer-run -a phi1612 -o stratum+tcp://eu1.altminer.net:11000 -u Lag3ink8cbBAJcmToS8jp3VCeqV8rZfENQ.$MY_RIG -p c=LUX
~/miner/tpruvot/ccminer-run -a nist5 -o stratum+tcp://pool.bsod.pw:3833 -u bNRVpP2b7jrYEw15wZbuuCZgeTNac1WXVD.$MY_RIG -p c=LUX
#~/miner/ccminer-xevan/ccminer-run -a xevan -o stratum+tcp://s.umine.org:3739 -u ScPpvD2vgRB95b8VF2CXdN3RdxG9HpLBQH.$MY_RIG -p c=XLR
#~/miner/tpruvot/ccminer/ccminer -a lyra2v2 -o stratum+tcp://pool1.phi-phi-pool.com:4533 -u $MY_ADDRESS.$MY_RIG -p c=BTC
#~/miner/klaust/ccminer/ccminer -a c11 -o stratum+tcp://pool1.phi-phi-pool.com:3573 -u $MY_ADDRESS.$MY_RIG -p c=BTC
