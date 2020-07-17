public class FastJsonTest {
 
    public static void main(String[] args) {
        String str = "{\"g\":\"\\x";
        Object obj = JSON.parse(str);
        System.out.println(str);
    }
 
}