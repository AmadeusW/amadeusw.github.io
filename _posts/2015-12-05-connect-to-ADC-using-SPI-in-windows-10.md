---
layout: post
title: Connect Windows 10 to ADC using SPI
category: iot
permalink: iot/connect-to-ADC-using-SPI-in-windows-10
tags: [iot, debugging, windows]
---

The smart mirror project recently entered the exciting part of working with hardware! The goal is to enable hand wave gesture recognition using two distance sensors placed on either side of the mirror. The first step is to get the data from the sensors and see how it looks like. In this blog post I wanted to focus specifically on **connecting Raspberry Pi to the MCP3008 analog to digital converter using SPI**, based on the [Potentiometer Sensor Sample](https://ms-iot.github.io/content/en-US/win10/samples/Potentiometer.htm) ([on github](https://github.com/ms-iot/samples/tree/develop/PotentiometerSensor/CS)).

For the complete process of connecting distance sensors to Raspberry Pi, see

* [![thumbnail](http://i.ytimg.com/vi/4mIuIHNF3JA/default.jpg)Smart Mirror episode 6 - Distance Sensor, ADC, SPI - circuit](http://youtu.be/4mIuIHNF3JA)
* [![thumbnail](http://i.ytimg.com/vi/dbNHNvUq2So/default.jpg)Smart Mirror episode 7 - Distance Sensor, ADC, SPI - code](https://youtu.be/dbNHNvUq2So)

# A few pointers regarding the hardware

See [Raspberry Pi 2 Pin Mappings](https://ms-iot.github.io/content/en-US/win10/samples/PinMappingsRPi2.htm) and [MCP3008 datasheet](http://ww1.microchip.com/downloads/en/DeviceDoc/21295d.pdf). 
 
* Connect Pi `SPI MOSI` to MCP3008 `Din`, and Pi `SPI MISO` to MCP3008 `Dout`
 * initially I thought I need to connect output of one device to the input of another device
* Use either Pi's `SPI CS0` or `SPI CS1` pin, you can pick one to use in the code 
 * this means that you can connect two SPI devices

![circuit diagram](/blogData/connect-to-ADC-using-SPI-in-windows-10/circuit.png)

# Connecting to SPI device

To connect to the ADC, you need to obtain an instance of `SpiDevice` from `Widows.Devices.Spi` namespace. To access this namespace, you need to first add a reference to "Windows IoT Extensions for the UWP"

![adding a reference](/blogData/connect-to-ADC-using-SPI-in-windows-10/reference.png)

Alright, let's instantiate the `SpiDevice`. This code is adapted from the Potentiometer Sensor Sample.

This is boilerplate code where I would pay attention mostly to `SpiConnectionSettings`. The parameter is the **Chip Select** line you used in the circuit, and `ClockFrequency` should not exceed the maximum frequency specified by the device's datasheet.

```csharp
SpiDevice ADC;
// . . .
var settings = new SpiConnectionSettings(0)                         // Chip Select line 0
{
    ClockFrequency = 500 * 1000,                                    // Don't exceed 3.6 MHz
    Mode = SpiMode.Mode0,
};

string spiAqs = SpiDevice.GetDeviceSelector("SPI0");                /* Find the selector string for the SPI bus controller          */
var devicesInfo = await DeviceInformation.FindAllAsync(spiAqs);     /* Find the SPI bus controller device with our selector string  */
ADC = await SpiDevice.FromIdAsync(devicesInfo[0].Id, settings);     /* Create an SpiDevice with our bus controller and SPI settings */
```

# Getting data from the SPI device

Now here's the real challenging code, and we'll get into detail:

```csharp
byte[] request = new byte[3] { 0x01, 0x80, 0 };
byte[] response = new byte[3];
// . . .        
ADC.TransferFullDuplex(request, response);
```

First, we need to establish size of the buffers. Let's start with the response buffer: 

The ADC response is 10 bits long. We can fit it into 2 bytes. We also add one byte padding. Hence, the response is 3 bytes long.

In SPI communication, for every byte we want to receive, we send one byte. Therefore, the request bytes are also 3 bytes long.

Now, what do we send? The ADC datasheets calls for a 4 bit pattern `1000` to read from the first channel, and `1001` to read from the second channel.
A few pages further, the datasheet also says that the message needs to be preceeded with a `1` bit. So, to read values from the first channel, we send `11000`.

Here is where various code snippets I found online get confusing: You can convert `11000` to hexadecimal `0x18`. and `110000` to `0x30`. Both approaches will work, but let's write maintainable code. 

We just need to split the bytes in a different way: The first byte will contain the initial `1`, and the second byte will contain the channel selecting pattern. Hence, we will send `0000 0001 1000 xxxx xxxx xxxx` (`x` is `don't care`), which translates to `{ 0x01, 0x80, 0 }`. Any change of the pattern will be reflected exclusively in the third hexadecimal digit (now `8`).

# Converting byte[] to int

Finally, we must convert the raw response of type `byte[]` to a more useful type, such as `int`. What happens in the `ConvertToInt` method, then?

```csharp
int result = 0;
result = data[1] & 0x03;
result <<= 8;
result += data[2];
return result;
```

The datasheet of the ADC says that the device outputs 10-bit chunks of data. The ten bytes with actual data are in `bbCCCCcccc`. This code extracts these ten bytes from the input `data` array.

Let's illustrate this code by plugging in values into variables. Suppose that `byte[] data` looks like this: `AAAAaaaa BBBBbbbb CCCCcccc`.

* `data[1] & 0x03` becomes `BBBBbbbb & 00000011`, which is `000000bb`
* `result <<= 8` transforms this into `000000bb 00000000`. 
* `result += data[2];` produces `000000bb CCCCcccc`, which is the ten bits that we were after

# Conclusion

These were the biggest obstacles that I had working with the SPI code. There is some non trivial math in this code, so feel free to ask a question in the comments below or reach out to me on Twitter [@HiAmadeus](https://twitter.com/HiAmadeus). To see how this code is used, watch [Smart Mirror episode 7 - Distance Sensor, ADC, SPI - code](https://youtu.be/dbNHNvUq2So).

Happy hacking!
