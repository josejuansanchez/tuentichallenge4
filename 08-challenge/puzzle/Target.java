public class Target {

    public static  short[][] target;
    private final int dim;

    public Target(int[][] target) {
        this.target = copySquareArray(target);
        dim = target.length;
    }

    // Copy a square array.
    private short[][] copySquareArray(int[][] original) {
        int len = original.length;
        short[][] copy = new short[len][len];
        for (int row = 0; row < len; row++) {
            assert original[row].length == len;
            for (int col = 0; col < len; col++)
                // Assignment guarantees dim < 128, so casting is safe.
                copy[row][col] = (short) original[row][col];
        }
        return copy;
    }
}