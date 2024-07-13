function Xt_plus_1 = fs01(Xt, w)
    % Reconstructing the structure space with ts1
    xr = ts1(Xt, w);    
    xs0 = xr(end, :);
    
    % Finding nearest analogs
    c = [];
    for j = 1:w
        c1 = ((xr(1:end-1, j) - xs0(j))).^2;
        c = [c c1];
    end
    cmetr = c';
    [o, ini] = sort(sqrt(sum(cmetr)));
    ini = ini(1:w+1);
    A = xr(ini, :);
    Xf = xr(ini+1, 1);

    % Local linear model
    [g, rn, res] = lsqlin(A, Xf, [], [], [], [], -1*ones(1, w), 1*ones(1, w)); % Optimizes the local linear model
    Xt_plus_1 = xr(end, :) * g; % Continuation of the most recent analog with optimum linear model
end

