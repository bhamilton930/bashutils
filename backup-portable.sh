#!/bin/bash

#backup all - even existing

# rsync -rtvz /storage/usb1/ pi@192.168.1.100:/storage/usb1

#backup except existing
rsync -rtuv --exclude 'music' /storage/usb1/* pi@192.168.1.100:/storage/usb1

